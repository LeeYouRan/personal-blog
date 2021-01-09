<?php

namespace seraph_pds;

require_once( ABSPATH . 'wp-includes/pluggable.php' );

function OnAdminApi_GetBindedPostIdByDocGuid( $args )
{
	global $wpdb;

	$fileGuid = @$args[ 'fileGuid' ];

	$postId = $wpdb -> get_var( 'SELECT post_id FROM ' . $wpdb -> postmeta . ' WHERE meta_key=\'_seraph_pds_BindGuid\' AND meta_value=\'' . esc_sql( $fileGuid ) . '\'' );
	return( $postId ? intval( $postId ) : null );
}

function OnAdminApi_UpdatePostInfo( $args )
{
	Wp::RemoveLangAttachmentFilters();

	$resCheckAccess = _AdminApi_CheckRights();
	if( $resCheckAccess )
		return( $resCheckAccess );

	$data = file_get_contents( 'php://input' );
	if( empty( $data ) )
		return( array( 'status' => 'invaliddata' ) );

	$data = json_decode( $data, true );
	if( !$data )
		return( array( 'status' => 'fail', 'statusDescr' => 'Data JSON parse: ' . json_last_error_msg() ) );

	$post = null;
	$postId = 0;
	{
		if( isset( $args[ 'id' ] ) )
		{
			$postId = intval( $args[ 'id' ] );
			$post = get_post( $postId );
			if( !$post )
				return( array( 'status' => 'notfound' ) );

			if( $post -> post_type != $args[ 'type' ] )
				return( array( 'status' => 'wrongtype' ) );
		}
		else
		{
			if( empty( $data[ 'title' ] ) )
				$data[ 'title' ] = 'New ' . $args[ 'type' ];

			$postId = wp_insert_post( array( 'post_title' => wp_slash( $data[ 'title' ] ), 'post_type' => $args[ 'type' ], 'post_content' => '', 'comment_status' => 'open' ) );
			if( !( $postId > 0 ) )
				return( array( 'status' => 'fail' ) );

			unset( $data[ 'title' ] );

			$post = get_post( $postId );
		}
	}

	$arrWarn = array();
	$res = SetPostData( $post, $data, $arrWarn );

	return( array( 'status' => $res[ 'res' ], 'statusDescr' => @$res[ 'descr' ], 'warnings' => $arrWarn, 'data' => array( 'id' => $postId, 'mediaUrl' => Wp::GetMediaUploadUrl( $post, true ), 'postUrl' => get_permalink( $post ), 'postEditUrl' => get_edit_post_link( $post, '' ), 'postSlug' => get_post_field( 'post_name', $post ), 'postTitle' => get_post_field( 'post_title', $post ) ) ) );
}

function OnAdminApi_UpdatePostData( $args )
{
	Wp::RemoveLangAttachmentFilters();

	$postId = intval( $args[ 'id' ] );
	$post = get_post( $postId );
	if( empty( $post ) )
		return( array( 'status' => 'notfound' ) );

	$data = file_get_contents( 'php://input' );
	if( empty( $data ) )
		return( array( 'status' => 'invaliddata' ) );

	$data = json_decode( $data, true );
	if( !$data )
		return( array( 'status' => 'fail', 'statusDescr' => 'Data JSON parse: ' . json_last_error_msg() ) );

	$arrWarn = array();
	$res = SetPostData( $post, $data, $arrWarn );

	return( array( 'status' => $res[ 'res' ], 'statusDescr' => @$res[ 'descr' ], 'warnings' => $arrWarn ) );
}

function OnAdminApi_SanitizeLabel( $args )
{
	return( sanitize_title( $args[ "str" ] ) );
}

function OnAdminApi_GetAttachmentIdFromUrl( $args )
{
	return( Wp::GetAttachmentIdFromUrl( $args[ 'url' ], @$args[ 'lang' ] ) );
}

function OnAdminApi_GetUrl( $args )
{
	if( !@$args[ 'raw' ] )
		return( getUrl( $args[ 'url' ], !empty( $args[ 'body' ] ) ) );

	Plugin::ApiCall_EnableOutput();
	getUrlRaw( $args[ 'url' ] );
}

function OnAdminApi_UploadImage( $args )
{
	Wp::RemoveLangAttachmentFilters();

	$data = fopen( 'php://input', 'rb' );

	$resample = @$args[ 'resample' ];
	if( $resample )
		$resample = @json_decode( base64_decode( stripslashes( $resample ) ), true );

	$res = UploadImage( $args[ 'filename' ], $args[ 'contentType' ], $data, @$args[ 'postId' ], @$args[ 'addToAttachments' ] == "true", @$args[ 'overwrite' ] == "true", @$args[ 'uploadDir' ], @$args[ 'uploadDirSubDir' ], array( 'title' => @$args[ 'title' ], 'altText' => @$args[ 'altText' ], 'description' => @$args[ 'description' ], 'caption' => @$args[ 'caption' ] ), $resample, @$args[ 'lang' ] );

	$ret = null;
	if( !is_wp_error( $res ) )
	{
		foreach( $res[ 'warnings' ] as &$warning )
			$warning = array( 'status' => $warning -> get_error_code(), 'statusDescr' => $warning -> get_error_message() );

		$ret = array( 'status' => 'ok', 'data' => $res );
	}
	else
		$ret = array( 'status' => $res -> get_error_code(), 'statusDescr' => $res -> get_error_message() );

	fclose( $data );
	return( $ret );
}

function OnAdminApi_UpdatePostTypeTaxonomies( $args )
{
	$data = file_get_contents( 'php://input' );
	if( empty( $data ) )
		return( null );

	$data = json_decode( $data, true );
	if( !is_array( $data ) )
		return( null );

	$lang = @$args[ 'lang' ];

	$res = Wp::UpdatePostTypeTaxonomies( $data, $args[ 'taxonomy' ], $args[ 'postType' ], $lang );
	return( $res );
}

function _AdminApi_CheckRights()
{
	if( current_user_can( 'publish_posts' ) )
		return( null );
	return( array( 'status' => 'accessdenied' ) );
}

function SetPostData( $post, $data, &$arrWarn )
{
	$rmtCfg = PluginRmtCfg::Get();
	$availablePlugins = Plugin::GetAvailablePlugins();

	$slug = @$data[ 'slug' ];

	{
		$argsUpdatePost = array();

		{
			$title = @$data[ 'title' ];
			if( $title )
				$argsUpdatePost[ 'post_title' ] = $title;
		}

		{
			if( $slug !== null )
				$argsUpdatePost[ 'post_name' ] = $slug;
		}

		{
			$excerpt = @$data[ 'excerpt' ];
			if( $excerpt !== null )
				$argsUpdatePost[ 'post_excerpt' ] = $excerpt;
		}

		{
			$date = @$data[ 'date' ];
			if( !empty( $date ) )
			{
				$argsUpdatePost[ 'edit_date' ] = true;
				$argsUpdatePost[ 'post_date' ] = get_date_from_gmt( $date );
				$argsUpdatePost[ 'post_date_gmt' ] = $date;
			}
		}

		{
			$text = @$data[ 'text' ];
			if( $text !== null )
				$argsUpdatePost[ 'post_content' ] = $text;
		}

		{
			$status = @$data[ 'status' ];
			if( !empty( $status ) )
				$argsUpdatePost[ 'post_status' ] = $status;
		}

		if( !empty( $argsUpdatePost ) )
		{
			$argsUpdatePost[ 'ID' ] = $post -> ID;

			$updRes = wp_update_post( wp_slash( $argsUpdatePost ), true );
			if( is_wp_error( $updRes ) )
				return( array( 'res' => 'fail', 'descr' => $updRes -> get_error_message() ) );
		}
	}

	{
		$categories = @$data[ 'categories' ];
		if( $categories !== null )
		{
			$applied = false;

			$postTypesTaxonomy = Wp::GetPostsTaxonomies( Wp::POST_TAXONOMY_TYPE_CATEGORY );
			if( !empty( $postTypesTaxonomy ) )
			{
				$postTaxonomy = $postTypesTaxonomy[ $post -> post_type ];
				if( !empty( $postTaxonomy ) )
				{

					wp_set_post_terms( $post -> ID, $categories, $postTaxonomy );

					$applied = true;
				}
			}

			if( !$applied )
				$arrWarn[] = _x( 'CatsNotSet', 'admin.Msg', 'seraphinite-post-docx-source' );
		}
	}

	{
		$keywords = @$data[ 'keywords' ];
		if( $keywords !== null )
		{
			$applied = false;

			$postTypesTaxonomy = Wp::GetPostsTaxonomies( Wp::POST_TAXONOMY_TYPE_TAG );
			if( !empty( $postTypesTaxonomy ) )
			{
				$postTaxonomy = $postTypesTaxonomy[ $post -> post_type ];
				if( !empty( $postTaxonomy ) )
				{

					wp_set_post_terms( $post -> ID, $keywords, $postTaxonomy );

					$applied = true;
				}
			}

			if( !$applied )
				$arrWarn[] = _x( 'KeywordsNotSet', 'admin.Msg', 'seraphinite-post-docx-source' );
		}
	}

	{
		$featuredImage = @$data[ 'featuredImage' ];
		if( $featuredImage !== null )
		{
			if( !$featuredImage )
			{
				$thumbnailId = get_post_thumbnail_id( $post );
				if( $thumbnailId )
				{
					delete_post_thumbnail( $post );

					$updRes = wp_update_post( array( 'ID' => $thumbnailId, 'post_parent' => 0 ), true );
					if( is_wp_error( $updRes ) )
						$arrWarn[] = sprintf( _x( 'FeaturImgNotUpdated_%1$s', 'admin.Msg', 'seraphinite-post-docx-source' ), $updRes -> get_error_message() );
				}
			}
			else
			{

				set_post_thumbnail( $post, $featuredImage );

				$updRes = wp_update_post( array( 'ID' => $featuredImage, 'post_parent' => $post -> ID ), true );
				if( is_wp_error( $updRes ) )
					$arrWarn[] = sprintf( _x( 'FeaturImgNotSet_%1$s', 'admin.Msg', 'seraphinite-post-docx-source' ), $updRes -> get_error_message() );
			}
		}
	}

	{
		$images = @$data[ 'wooProductGalleryImages' ];
		if( $images !== null )
			update_post_meta( $post -> ID, '_product_image_gallery', implode( ',', $images ) );
	}

	{
		$titleSeo = @$data[ 'titleSeo' ];
		if( $titleSeo !== null )
		{
			$bSet = false;

			if( in_array( 'all-in-one-seo-pack', $availablePlugins ) )
			{
				if( empty( $titleSeo ) )
					delete_post_meta( $post -> ID, '_aioseop_title' );
				else
					update_post_meta( $post -> ID, '_aioseop_title', $titleSeo );
				$bSet = true;
			}

			if( in_array( 'seo-by-rank-math', $availablePlugins ) )
			{
				if( empty( $titleSeo ) )
					delete_post_meta( $post -> ID, 'rank_math_title' );
				else
					update_post_meta( $post -> ID, 'rank_math_title', $titleSeo );
				$bSet = true;
			}

			if( in_array( 'wp-seopress', $availablePlugins ) )
			{
				if( empty( $titleSeo ) )
					delete_post_meta( $post -> ID, '_seopress_titles_title' );
				else
					update_post_meta( $post -> ID, '_seopress_titles_title', $titleSeo );
				$bSet = true;
			}

			if( in_array( 'wordpress-seo', $availablePlugins ) )
			{
				if( empty( $titleSeo ) )
					delete_post_meta( $post -> ID, '_yoast_wpseo_title' );
				else
					update_post_meta( $post -> ID, '_yoast_wpseo_title', $titleSeo );
				$bSet = true;
			}

			if( !$bSet )
				$arrWarn[] = vsprintf( _x( 'TitleSeoNotSet_%1$s%2$s', 'admin.Msg', 'seraphinite-post-docx-source' ), Ui::Link( array( '', '' ), Plugin::RmtCfgFld_GetLoc( $rmtCfg, 'Help.SupportedPlugins' ), true ) );
		}
	}

	{
		$descrSeo = @$data[ 'descrSeo' ];
		if( $descrSeo !== null )
		{
			$bSet = false;

			if( in_array( 'all-in-one-seo-pack', $availablePlugins ) )
			{
				if( empty( $descrSeo ) )
					delete_post_meta( $post -> ID, '_aioseop_description' );
				else
					update_post_meta( $post -> ID, '_aioseop_description', $descrSeo );
				$bSet = true;
			}

			if( in_array( 'seo-by-rank-math', $availablePlugins ) )
			{
				if( empty( $descrSeo ) )
					delete_post_meta( $post -> ID, 'rank_math_description' );
				else
					update_post_meta( $post -> ID, 'rank_math_description', $descrSeo );
				$bSet = true;
			}

			if( in_array( 'wp-seopress', $availablePlugins ) )
			{
				if( empty( $descrSeo ) )
					delete_post_meta( $post -> ID, '_seopress_titles_desc' );
				else
					update_post_meta( $post -> ID, '_seopress_titles_desc', $descrSeo );
				$bSet = true;
			}

			if( in_array( 'wordpress-seo', $availablePlugins ) )
			{
				if( empty( $descrSeo ) )
					delete_post_meta( $post -> ID, '_yoast_wpseo_metadesc' );
				else
					update_post_meta( $post -> ID, '_yoast_wpseo_metadesc', $descrSeo );
				$bSet = true;
			}

			if( !$bSet )
				$arrWarn[] = vsprintf( _x( 'DescrSeoNotSet_%1$s%2$s', 'admin.Msg', 'seraphinite-post-docx-source' ), Ui::Link( array( '', '' ), Plugin::RmtCfgFld_GetLoc( $rmtCfg, 'Help.SupportedPlugins' ), true ) );
		}
	}

	{
		$lang = @$data[ 'lang' ];
		if( $lang !== null )
		{
			$langDef = Wp::GetDefLang();

			$langsAvail = Wp::GetLangs();
			if( isset( $langsAvail[ $lang ] ) )
			{
				$postIdOrig = Wp::SETPOSTLANG_IDORIG_DONTCHANGE;

				$hr = Wp::SetPostLang( $post -> ID, $lang, $postIdOrig );
				if( Gen::HrFail( $hr ) && $hr != Gen::E_NOTIMPL )
					$arrWarn[] = sprintf( _x( 'LangNotSet_%1$s%2$x', 'admin.Msg', 'seraphinite-post-docx-source' ), $lang, $hr );

			}
			else
				$arrWarn[] = sprintf( _x( 'LangNotAvail_%1$s', 'admin.Msg', 'seraphinite-post-docx-source' ), $lang );
		}
	}

	{
		$attrs = @$data[ 'blocks' ];
		if( $attrs )
		{
			foreach( $attrs as $attrKey => $attr )
			{
				$attr = wp_slash( $attr );

				$posSep = strpos( $attrKey, '.' );
				if( $posSep !== false )
				{
					$arrFldPath = substr( $attrKey, $posSep + 1 );
					$attrKey = substr( $attrKey, 0, $posSep );

					$attrArr = get_post_meta( $post -> ID, $attrKey, true );
					if( !is_array( $attrArr ) )
						$attrArr = array();
					Gen::SetArrField( $attrArr, $arrFldPath, $attr );
					update_post_meta( $post -> ID, $attrKey, $attrArr );
				}
				else
				{
					if( empty( $attr ) )
						delete_post_meta( $post -> ID, $attrKey );
					else
						update_post_meta( $post -> ID, $attrKey, $attr );
				}
			}
		}
	}

	{
		SetPostBindGuid( $post -> ID, @$data[ 'fileGuid' ] );
	}

	return( array( 'res' => 'ok' ) );
}

function UploadImage( $fileName, $contentType, $data, $postId = 0, $addToAttachments = true, $overwrite = false, $uploadDir = null, $uploadDirSubDir = null, $attrs = null, $resample = null, $lang = null )
{
	global $ctxUploadImage;

	$ctxUploadImage = array(
		'addToAttachments'		=> $addToAttachments,
		'overwrite'				=> $overwrite,
		'fileName'				=> $fileName,

		'uploadDirSubDir'		=> $uploadDirSubDir,
		'lang'					=> $lang
	);

	if( !current_user_can( 'upload_files' ) )
		return( new \WP_Error( 'access_denied', _x( 'UserNotUploadFiles', 'admin.Msg', 'seraphinite-post-docx-source' ) ) );

	if( $postId && !current_user_can( 'edit_post', $postId ) )
		return( new \WP_Error( 'access_denied', _x( 'UserNotEditPost', 'admin.Msg', 'seraphinite-post-docx-source' ) ) );

	global $post, $post_id, $_GET;

	$post_prev = $post;
	$post_id_prev = $post_id;

	if( $postId )
	{
		$post = null;
		$post_id = $postId;
	}

	$fileNamePathTmp = Wp::GetTempFile();

	add_filter( 'wp_unique_filename',			'seraph_pds\\_wp_unique_filename_UploadImage', 1, 4 );
	add_filter( 'pre_move_uploaded_file',		'seraph_pds\\_pre_move_uploaded_file_UploadImage', 1, 4 );
	add_filter( 'wp_handle_upload',				'seraph_pds\\_handle_upload_UploadImage', 99999, 2 );
	add_filter( 'upload_dir',					'seraph_pds\\_upload_dir_UploadImage' );

	$res = _UploadImage( $fileNamePathTmp, $contentType, $data, $postId, $addToAttachments, $overwrite, $attrs, $resample, $lang );

	remove_filter( 'upload_dir',				'seraph_pds\\_upload_dir_UploadImage' );
	remove_filter( 'wp_handle_upload',			'seraph_pds\\_handle_upload_UploadImage', 99999 );
	remove_filter( 'pre_move_uploaded_file',	'seraph_pds\\_pre_move_uploaded_file_UploadImage', 1 );
	remove_filter( 'wp_unique_filename',		'seraph_pds\\_wp_unique_filename_UploadImage', 1, 4 );

	@unlink( $fileNamePathTmp );

	if( $postId )
	{
		$post = $post_prev;
		$post_id = $post_id_prev;
	}

	return( $res );
}

function _wp_unique_filename_UploadImage( $filename, $ext, $dir, $unique_filename_callback )
{
	global $ctxUploadImage;

	if( $ctxUploadImage[ 'overwrite' ] )
		$filename = $ctxUploadImage[ 'fileName' ];
	else
		Fs::CreateEmptyFile( $dir . '/' . $filename );

	return( $filename );
}

function _pre_move_uploaded_file_UploadImage( $move_new_file, $file, $new_file, $type )
{
	global $ctxUploadImage;

	if( @rename( $file[ 'tmp_name' ], $new_file ) === false )
	{
		$ctxUploadImage[ 'error' ] = 'Can\'t write to "' . $new_file . '"';
		return( $move_new_file );
	}

	return( true );
}

function _handle_upload_UploadImage( $info, $action )
{
	global $ctxUploadImage;

	if( $ctxUploadImage[ 'overwrite' ] )
	{
		$newFileExt = Gen::GetFileExt( $info[ 'file' ] );
		if( Gen::GetFileExt( $ctxUploadImage[ 'fileName' ] ) != $newFileExt )
		{
			$oldFileName = Gen::GetFileName( $ctxUploadImage[ 'fileName' ], true );

			$correctedNewFilePathName = dirname( $info[ 'file' ] ) . '/' . $oldFileName . '.' . $newFileExt;
			if( @rename( $info[ 'file' ], $correctedNewFilePathName ) === false )
			{
				$ctxUploadImage[ 'error' ] = 'Can\'t write to "' . $correctedNewFilePathName . '"';
			}
			else
			{
				$info[ 'file' ] = $correctedNewFilePathName;
				$info[ 'url' ] = dirname( $info[ 'url' ] ) . '/' . $oldFileName . '.' . $newFileExt;
			}
		}
	}

	$ctxUploadImage[ 'url' ] = $info[ 'url' ];
	if( $ctxUploadImage[ 'addToAttachments' ] && $ctxUploadImage[ 'overwrite' ] )
		$ctxUploadImage[ 'prevAttachmentId' ] = Wp::GetAttachmentIdFromUrl( $info[ 'url' ], $ctxUploadImage[ 'lang' ] );

	if( !$ctxUploadImage[ 'addToAttachments' ] )
		$info[ 'error' ] = 'warnAttachmentWasNotPut';

	return( $info );
}

function _upload_dir_UploadImage( $uploads )
{
	global $ctxUploadImage;

	$uploadDirSubDir = @$ctxUploadImage[ 'uploadDirSubDir' ];
	if( $uploadDirSubDir !== null )
	{

		{
			$subDirLen = strlen( $uploads[ 'subdir' ] );
			if( $subDirLen )
			{
				$uploads[ 'subdir' ] = '';
				$uploads[ 'path' ] = substr( $uploads[ 'path' ], 0, strlen( $uploads[ 'path' ] ) - $subDirLen );
				$uploads[ 'url' ] = substr( $uploads[ 'url' ], 0, strlen( $uploads[ 'url' ] ) - $subDirLen );
			}
		}

		{
			$uploads[ 'subdir' ] .= $uploadDirSubDir;
			$uploads[ 'path' ] .= $uploadDirSubDir;
			$uploads[ 'url' ] .= $uploadDirSubDir;
		}
	}

	return( $uploads );
}

function _GetImageInfo( $fileNamePath )
{
	$infoEx = array();

	$info = @getimagesize( $fileNamePath, $infoEx );
	if( !$info )
		return( null );

	$info = array( 'cx' => $info[ 0 ], 'cy' => $info[ 1 ], 'mime' => $info[ 'mime' ] );

	switch( $info[ 'mime' ] )
	{
	case 'image/gif':
		$info[ 'dpiX' ] = 96;
		$info[ 'dpiY' ] = 96;
		break;

	case 'image/png':

		$fh = @fopen( $fileNamePath, 'rb' );

		$buf = array();

		$x = 0;
		$y = 0;
		$units = 0;

		while( !@feof( $fh ) )
		{
			array_push( $buf, ord( @fread( $fh, 1 ) ) );
			if( count( $buf ) > 13 )
				array_shift( $buf );
			if( count( $buf ) < 13 )
				continue;

			if( $buf[ 0 ] == ord( 'p' ) &&
				$buf[ 1 ] == ord( 'H' ) &&
				$buf[ 2 ] == ord( 'Y' ) &&
				$buf[ 3 ] == ord( 's' ) )
			{
				$x = ( $buf[ 4 ] << 24 ) + ( $buf[ 5 ] << 16 ) + ( $buf[ 6 ] << 8 ) + $buf[ 7 ];
				$y = ( $buf[ 8 ] << 24 ) + ( $buf[ 9 ] << 16 ) + ( $buf[ 10 ] << 8 ) + $buf[ 11 ];
				$units = $buf[ 12 ];
				break;
			}
		}

		@fclose( $fh );

		switch( $units )
		{
		case 0:
			$info[ 'dpiX' ] = 96;
			$info[ 'dpiY' ] = intval( round( $info[ 'dpiX' ] * ( $x && $y ? ( $x / $y ) : 1 ) ) );
			break;

		case 1:
			$info[ 'dpiX' ] = intval( round( $x * 0.0254 ) );
			$info[ 'dpiY' ] = intval( round( $y * 0.0254 ) );
			break;
		}

		break;

	case 'image/tiff':
		break;

	case 'image/x-ms-bmp':

		$fh = @fopen( $fileNamePath, 'rb' );
		$raw = @fread( $fh, 14 + 40  );
		@fclose( $fh );

		$data = substr( $raw, 14 + 24, 8 );
		$info[ 'dpiX' ] = intval( @hexdec( @bin2hex( strrev( substr( $data, 0, 4 ) ) ) ) * 0.0254 );
		$info[ 'dpiY' ] = intval( @hexdec( @bin2hex( strrev( substr( $data, 4, 4 ) ) ) ) * 0.0254 );
		break;

	case 'image/jpeg':

		if( !$infoEx[ 'APP0' ] )
		{
			$fh = @fopen( $fileNamePath, 'rb' );
			$raw = @fread( $fh, 20 );
			@fclose( $fh );

			$infoEx[ 'APP0' ] = substr( $raw, 6 );
		}

		$data = @bin2hex( substr( $infoEx[ 'APP0' ], 8, 4 ) );

		$x = @hexdec( substr( $data, 0, 4 ) );
		$y = @hexdec( substr( $data, 4, 4 ) );
		$units = @hexdec( @bin2hex( substr( $infoEx[ 'APP0' ], 7, 1 ) ) );

		switch( $units )
		{
		case 0:
			$info[ 'dpiX' ] = 96;
			$info[ 'dpiY' ] = intval( round( $info[ 'dpiX' ] * $x / $y ) );
			break;

		case 1:
			$info[ 'dpiX' ] = $x;
			$info[ 'dpiY' ] = $y;
			break;

		case 2:
			$info[ 'dpiX' ] = intval( round( $x * 2.54 ) );
			$info[ 'dpiY' ] = intval( round( $y * 2.54 ) );
			break;
		}

		break;
	}

	return( $info );
}

function _CopyResampleImage( $img, $rcSrc, $rcDst, $sizeDst, $bgClr = null )
{
	$imgNew = @imagecreatetruecolor( $sizeDst[ 'cx' ], $sizeDst[ 'cy' ] );
	if( $imgNew === false )
		return( null );

	imagesavealpha( $imgNew, true );
	imagefill( $imgNew, 0, 0, imagecolorallocatealpha( $imgNew, 0, 0, 0, 127 ) );

	if( $bgClr !== null )
		imagefilledrectangle( $imgNew, 0, 0, $sizeDst[ 'cx' ] - 1, $sizeDst[ 'cy' ] - 1, imagecolorallocate( $imgNew, ( $bgClr >> 16 ) & 0xFF, ( $bgClr >> 8 ) & 0xFF, $bgClr & 0xFF ) );

	if( function_exists( 'imageantialias' ) )
		imageantialias( $imgNew, true );

	if( !imagecopyresampled( $imgNew, $img,
		$rcDst[ 'x' ], $rcDst[ 'y' ],
		$rcSrc[ 'x' ], $rcSrc[ 'y' ],
		$rcDst[ 'cx' ], $rcDst[ 'cy' ],
		$rcSrc[ 'cx' ], $rcSrc[ 'cy' ] ) )
	{
		imagedestroy( $imgNew );
		return( null );
	}

	return( $imgNew );
}

function _GetImageQuality( $mimeType, $quality = null )
{
	$qualityDef = 82;

	if( $quality === null )
	{
		$quality = apply_filters( 'wp_editor_set_quality', $qualityDef, $mimeType );
		if( 'image/jpeg' == $mimeType )
			$quality = apply_filters( 'jpeg_quality', $quality, 'image_resize' );
	}

	if( $quality < 0 || $quality > 100 )
		$quality = $qualityDef;

	if ( 0 === $quality )
		$quality = 1;

	return( $quality );
}

function _SaveImage( $img, $filename, $mimeType, $fileExt, $quality = null )
{
	if( 'image/gif' == $mimeType )
	{
		if( !call_user_func_array( 'imagegif', array( $img, $filename ) ) )
			return( false );
	}
	else if( 'image/jpeg' == $mimeType )
	{
		if( !call_user_func_array( 'imagejpeg', array( $img, $filename, _GetImageQuality( $mimeType, $quality ) ) ) )
			return( false );
	}
	else
	{

		if( function_exists( 'imageistruecolor' ) && !imageistruecolor( $img ) )
			imagetruecolortopalette( $img, false, imagecolorstotal( $img ) );

		if( !call_user_func_array( 'imagepng', array( $img, $filename ) ) )
			return( false );

		if( 'image/png' != $mimeType )
		{
			$mimeType = 'image/png';
			$fileExt = $fileExt . '.png';
		}
	}

	return( array( 'mime' => $mimeType, 'ext' => $fileExt ) );
}

function _IntRoundVal( $v, $round = true )
{
	return( intval( $round ? round( $v ) : $v ) );
}

function _ConvertImage( $fileNamePath, $resample, $mimeType, $fileExt, $force )
{
	if( !is_array( $resample ) )
		$resample = array();

	$crop = @$resample[ 'crop' ];
	if( !is_array( $crop ) )
		$crop = array();

	$cropSkip = $crop[ 'skip' ];

	$resizeEmu = @$resample[ 'sizeEmu' ];

	if( !$force &&
		!$crop[ 'l' ] && !$crop[ 't' ] && !$crop[ 'r' ] && !$crop[ 'b' ] && !$resizeEmu )
		return( null );

	if( $crop[ 'l' ] + $crop[ 'r' ] > 1.0 )
		$crop[ 'r' ] = 1.0 - $crop[ 'l' ];
	if( $crop[ 't' ] + $crop[ 'b' ] > 1.0 )
		$crop[ 'b' ] = 1.0 - $crop[ 't' ];

	$info = _GetImageInfo( $fileNamePath );
	if( !$info )
		return( new \WP_Error( 'invalid_image', Wp::GetLocString( 'Could not read image size.' ), $fileNamePath ) );

	$cropPositive = array(
		'l' => $crop[ 'l' ] >= 0 ? _IntRoundVal( $crop[ 'l' ] * $info[ 'cx' ], false ) : 0,
		't' => $crop[ 't' ] >= 0 ? _IntRoundVal( $crop[ 't' ] * $info[ 'cy' ], false ) : 0,
		'r' => $crop[ 'r' ] >= 0 ? _IntRoundVal( $crop[ 'r' ] * $info[ 'cx' ], false ) : 0,
		'b' => $crop[ 'b' ] >= 0 ? _IntRoundVal( $crop[ 'b' ] * $info[ 'cy' ], false ) : 0,
	);

	$cropNegative = array(
		'l' => $crop[ 'l' ] < 0 ? _IntRoundVal( -$crop[ 'l' ] * $info[ 'cx' ], false ) : 0,
		't' => $crop[ 't' ] < 0 ? _IntRoundVal( -$crop[ 't' ] * $info[ 'cy' ], false ) : 0,
		'r' => $crop[ 'r' ] < 0 ? _IntRoundVal( -$crop[ 'r' ] * $info[ 'cx' ], false ) : 0,
		'b' => $crop[ 'b' ] < 0 ? _IntRoundVal( -$crop[ 'b' ] * $info[ 'cy' ], false ) : 0,
	);

	$rcSrc = array( 'x' => $cropPositive[ 'l' ], 'y' => $cropPositive[ 't' ], 'cx' => $info[ 'cx' ] - ( $cropPositive[ 'l' ] + $cropPositive[ 'r' ] ), 'cy' => $info[ 'cy' ] - ( $cropPositive[ 't' ] + $cropPositive[ 'b' ] ) );
	$sizeDst = array( 'cx' => $rcSrc[ 'cx' ] + ( $cropNegative[ 'l' ] + $cropNegative[ 'r' ] ), 'cy' => $rcSrc[ 'cy' ] + ( $cropNegative[ 't' ] + $cropNegative[ 'b' ] ) );

	$resizeCoeff = array( 'x' => 1.0, 'y' => 1.0 );
	if( $resizeEmu && $info[ 'dpiX' ] && $info[ 'dpiY' ] )
	{

		$sizeEmu2Pix = array( 'cx' => $resizeEmu[ 'cx' ] / 914400 * 96, 'cy' => $resizeEmu[ 'cy' ] / 914400 * 96 );
		$resizeCoeff = array( 'x' => $sizeEmu2Pix[ 'cx' ] / $sizeDst[ 'cx' ], 'y' => $sizeEmu2Pix[ 'cy' ] / $sizeDst[ 'cy' ] );
	}

	if( $cropSkip )
	{
		$cropPositive = array(
			'l' => 0,
			't' => 0,
			'r' => 0,
			'b' => 0,
		);

		$cropNegative = array(
			'l' => 0,
			't' => 0,
			'r' => 0,
			'b' => 0,
		);

		$rcSrc = array( 'x' => 0, 'y' => 0, 'cx' => $info[ 'cx' ], 'cy' => $info[ 'cy' ] );
		$sizeDst = array( 'cx' => $rcSrc[ 'cx' ], 'cy' => $rcSrc[ 'cy' ] );
	}

	$sizeDstRs = array( 'cx' => _IntRoundVal( $resizeCoeff[ 'x' ] * $sizeDst[ 'cx' ] ), 'cy' => _IntRoundVal( $resizeCoeff[ 'y' ] * $sizeDst[ 'cy' ] ) );

	$nameSuffix = '';
	{
		if( $cropPositive[ 'l' ] )
			$nameSuffix .= $cropPositive[ 'l' ] . 'l';
		if( $cropNegative[ 'l' ] )
			$nameSuffix .= $cropNegative[ 'l' ] . 'ln';

		if( $cropPositive[ 't' ] )
			$nameSuffix .= $cropPositive[ 't' ] . 't';
		if( $cropNegative[ 't' ] )
			$nameSuffix .= $cropNegative[ 't' ] . 'tn';

		if( $cropPositive[ 'r' ] )
			$nameSuffix .= $cropPositive[ 'r' ] . 'r';
		if( $cropNegative[ 'r' ] )
			$nameSuffix .= $cropNegative[ 'r' ] . 'rn';

		if( $cropPositive[ 'b' ] )
			$nameSuffix .= $cropPositive[ 'b' ] . 'b';
		if( $cropNegative[ 'b' ] )
			$nameSuffix .= $cropNegative[ 'b' ] . 'bn';

		if( $sizeDst[ 'cx' ] != $sizeDstRs[ 'cx' ] )
			$nameSuffix .= $sizeDstRs[ 'cx' ] . 'w';
		if( $sizeDst[ 'cy' ] != $sizeDstRs[ 'cy' ] )
			$nameSuffix .= $sizeDstRs[ 'cy' ] . 'h';

		if( empty( $nameSuffix ) )
		{
			if( !$force )
				return( null );
		}
		else
			$nameSuffix = '-' . $nameSuffix;
	}

	{
		$img = @imagecreatefromstring( file_get_contents( $fileNamePath ) );
		if( !is_resource( $img ) )
			return( new \WP_Error( 'invalid_image', Wp::GetLocString( 'File is not an image.' ), $fileNamePath ) );

		if( function_exists( 'imagealphablending' ) && function_exists( 'imagesavealpha' ) )
		{
			imagealphablending( $img, false );
			imagesavealpha( $img, true );
		}

		{
			$imgNew = _CopyResampleImage( $img,
				$rcSrc,
				array( 'x' => _IntRoundVal( $resizeCoeff[ 'x' ] * $cropNegative[ 'l' ] ), 'y' => _IntRoundVal( $resizeCoeff[ 'y' ] * $cropNegative[ 't' ] ), 'cx' => _IntRoundVal( $resizeCoeff[ 'x' ] * $rcSrc[ 'cx' ] ), 'cy' => _IntRoundVal( $resizeCoeff[ 'y' ] * $rcSrc[ 'cy' ] ) ),
				$sizeDstRs,
				$info[ 'mime' ] != 'image/png' ? 0xFFFFFF : null );

			if( $imgNew === null )
			{
				imagedestroy( $img );
				return( new \WP_Error( 'image_resize_error', Wp::GetLocString( 'Image resize failed.' ), $fileNamePath ) );
			}

			imagedestroy( $img );
			$img = $imgNew;
			unset( $imgNew );
		}

		$resSave = _SaveImage( $img, $fileNamePath, $info[ 'mime' ], $fileExt );
		if( !$resSave )
		{
			imagedestroy( $img );
			return( new \WP_Error( 'image_save_error', Wp::GetLocString( 'Image Editor Save Failed' ) ) );
		}

		imagedestroy( $img );

		$fileExt = $resSave[ 'ext' ];
		$mimeType = $resSave[ 'mime' ];
	}

	return( array( 'suffix' => $nameSuffix . '.' . $fileExt, 'mime' => $mimeType ) );
}

function _UploadImage( $fileNamePathTmp, $contentType, $data, $postId, $addToAttachments, $overwrite, $attrs, $resample, $lang )
{
	global $ctxUploadImage;

	$fileNamePathTmpSize = 0;
	{
		$file = @fopen( $fileNamePathTmp, 'wb' );
		if( $file === false )
			return( new \WP_Error( 'internal_error', sprintf( _x( 'NotCreateTmpFile_%1$s', 'admin.Msg', 'seraphinite-post-docx-source' ), $fileNamePathTmp ) ) );

		if( Fs::StreamCopy( $data, $file ) != Gen::S_OK )
			$err = new \WP_Error( 'internal_error', sprintf( _x( 'NotCopyToTmpFile_%1$s', 'admin.Msg', 'seraphinite-post-docx-source' ), $fileNamePathTmp ) );

		$fileNamePathTmpSize = @filesize( $fileNamePathTmp );

		fclose( $file );
		if( $err )
			return( $err );
	}

	if( !$fileNamePathTmpSize )
		return( new \WP_Error( 'error_void_content', _x( 'NotUploadZeroContent', 'admin.Msg', 'seraphinite-post-docx-source' ) ) );

	$warnings = array();

	$forceConvert = $contentType == 'image/bmp';
	{
		$res = _ConvertImage( $fileNamePathTmp, $resample, $contentType, Gen::GetFileExt( $ctxUploadImage[ 'fileName' ] ), $forceConvert );
		if( is_wp_error( $res ) )
			$warnings[] = $res;
		else if( !empty( $res ) )
		{
			$ctxUploadImage[ 'fileName' ] = Gen::GetFileName( $ctxUploadImage[ 'fileName' ], true, true ) . $res[ 'suffix' ];
			$contentType = $res[ 'mime' ];
		}
	}

	$_FILES[ 'f' ] = array(
		'name'					=> $ctxUploadImage[ 'fileName' ],
		'tmp_name'				=> $fileNamePathTmp,
		'type'					=> $contentType,
		'size'					=> $fileNamePathTmpSize,
		'error'					=> 0,
	);

	$_FILES[ 'f' ] = apply_filters( 'wp_handle_upload_prefilter', $_FILES[ 'f' ] );

	$updateAttachment = $addToAttachments && $overwrite;

	$attachmentId = null;
	$metadata = null;
	{
		$res = media_handle_upload( 'f', $postId, array(), array( 'test_form' => false, 'action' => 'wp_handle_sideload' ) );
		if( is_wp_error( $res ) )
		{
			$warnAttachmentWasNotPut = $res -> get_error_code() == 'upload_error' && $res -> get_error_message() == 'warnAttachmentWasNotPut';
			if( !$warnAttachmentWasNotPut )
				return( $res );
		}
		else
		{
			if( !Gen::IsEmpty( @$ctxUploadImage[ 'error' ] ) )
				return( new \WP_Error( 'internal_error', @$ctxUploadImage[ 'error' ] ) );

			$attachmentId = $res;

			if( $updateAttachment )
			{
				$prevAttachmentId = $ctxUploadImage[ 'prevAttachmentId' ];

				if( $prevAttachmentId )
				{
					$newAttachment = get_post( $attachmentId, ARRAY_A );
					$newAttachmentMetadata = wp_get_attachment_metadata( $attachmentId );

					{
						update_attached_file( $newAttachment[ 'ID' ], '' );

						$res = wp_delete_attachment( $newAttachment[ 'ID' ], true );
						if( is_wp_error( $res ) )
							return( $res );
					}

					$newAttachment[ 'ID' ] = $prevAttachmentId;

					{
						$res = wp_update_post( $newAttachment, true );
						if( is_wp_error( $res ) )
							return( $res );
					}

					wp_update_attachment_metadata( $prevAttachmentId, $newAttachmentMetadata );

					$attachmentId = $prevAttachmentId;
					$metadata = $newAttachmentMetadata;
				}
				else
					$metadata = wp_get_attachment_metadata( $attachmentId );
			}
			else
				$metadata = wp_get_attachment_metadata( $attachmentId );

			if( $addToAttachments )
			{

				{
					if( $lang !== null )
					{
						$hr = Wp::SetPostLang( $attachmentId, $lang );
						if( Gen::HrFail( $hr ) && $hr != Gen::E_NOTIMPL )
							$warnings[] = new \WP_Error( 'internal_error', 'Can\'t set \'' . $lang . '\' language: ' . sprintf( '0x%08X', $hr ) );
					}
				}

				{
					$updateData = array();

					$title = @$attrs[ 'title' ];
					if( $title )
						$updateData[ 'post_title' ] = $title;

					$altText = @$attrs[ 'altText' ];
					if( $altText )
						$updateData[ '_wp_attachment_image_alt' ] = $altText;

					$description = @$attrs[ 'description' ];
					if( $description )
						$updateData[ 'post_content' ] = $description;

					$caption = @$attrs[ 'caption' ];
					if( $caption )
						$updateData[ 'post_excerpt' ] = $caption;

					if( count( $updateData ) )
					{
						$res = Wp::UpdateAttachment( $attachmentId, wp_slash( $updateData ), true );
						if( is_wp_error( $res ) )
							return( $res );
					}
				}
			}

			if( !wp_prepare_attachment_for_js( $attachmentId ) )
				return( new \WP_Error( 'internal_error', 'prepare_attachment_for_js_failed' ) );
		}
	}

	return( array( 'url' => Net::Url2Uri( $ctxUploadImage[ 'url' ], true ), 'attachmentId' => $attachmentId, 'metadata' => $metadata, 'warnings' => $warnings ) );
}

