<?php

namespace seraph_pds;

if( !defined( 'ABSPATH' ) )
	exit;

const PLUGIN_SETT_VER								= 1;

const ShowOperateOptionsMode_Post					= 1;
const ShowOperateOptionsMode_Settings				= 2;
const ShowOperateOptionsMode_Batch_Operate			= 3;
const ShowOperateOptionsMode_Batch_Settings			= 4;
const ShowOperateOptionsMode_Batch_Report			= 5;

function _post_is_new( $post )
{
	return( 'auto-draft' === $post -> post_status );
}

function _ShowOperateOptions( $mode, $post = null )
{
	$rmtCfg = PluginRmtCfg::Get();
	$rmtCfgFldCtx = Plugin::RmtCfgFld_GetCtx( $rmtCfg );

	$sett = Plugin::SettGet();

	$availablePlugins = Plugin::GetAvailablePluginsEx( true );

	if( $mode == ShowOperateOptionsMode_Settings )
	{
		$licHtmlContent = Plugin::GetLockedFeatureLicenseContent( Plugin::DisplayContent_Block, '', vsprintf( _x( 'LockedFeatureInfo_%1$s%2$s%3$s%4$s', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ), \seraph_pds\Gen::ArrFlatten( array( \seraph_pds\Ui::Link( \seraph_pds\Ui::Tag( 'strong', array( '', '' ) ), \seraph_pds\Gen::GetArrField( $rmtCfg, 'LicCont.UrlPostCnvSettings' ), true ), \seraph_pds\Ui::Tag( 'strong', array( '', '' ) ) ) ) ) );
		if( !empty( $licHtmlContent ) )
			echo( \seraph_pds\Ui::Tag( 'p', $licHtmlContent ) . \seraph_pds\Ui::SepLine( 'p' ) );
	}

	if( $mode == ShowOperateOptionsMode_Batch_Settings )
	{
		$licHtmlContent = Plugin::GetLockedFeatureLicenseContent();
		if( !empty( $licHtmlContent ) )
			echo( \seraph_pds\Ui::Tag( 'p', $licHtmlContent ) . \seraph_pds\Ui::SepLine( 'p' ) );
	}

	$postIsNew = empty( $post ) ? false : _post_is_new( $post );
	$fileGuid = empty( $post ) ? null : GetPostBindGuid( $post -> ID );
	$postType = $post ? $post -> post_type : 'any';

	$googleDriveApiClientId = Gen::GetArrField( $sett, 'google/apiDrive/clientId', '', '/' );

	$aPostTypes = array();
	if( $mode != ShowOperateOptionsMode_Post )
		$aPostTypes = GetCompatiblePostsTypes();

	$settBlockClass = array();
	if( $mode != ShowOperateOptionsMode_Settings )
		$settBlockClass = array( 'compact' );

	if( $mode == ShowOperateOptionsMode_Post || $mode == ShowOperateOptionsMode_Batch_Operate )
	{

		{
			$vals = array(
				'Help.NonExistentLinks' => null,
				'Help.SeparateAttributes' => null,
				'Help.Tags' => null,
				'Help.Categories' => null,
				'Help.FeaturedImage' => null,
				'Help.WooGalleryImages' => null,
				'Help.SeoTitle' => null,
				'Help.SeoDescription' => null,
				'Help.Slug' => null,
				'Help.Lang' => null,
				'Help.Excerpt' => null,
				'Help.CustomAttrs' => null,
				'Help.UploadMedia' => null,
				'Help.HeadersDowngradeOverLevel' => null,
				'Help.PostIdBinding' => null,
				'Help.PostIdBindingByGuid' => null,
				'Help.PostIdBindingByPostId' => null,
			);

			foreach( $vals as $valId => &$val )
				$val = Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, $valId );

			echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_rmtCfg', 'value' => rawurlencode( wp_json_encode( $vals ) ) ), true ) );
		}

		echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_info', 'value' => rawurlencode( wp_json_encode( array(
			'siteAddr' => \seraph_pds\Gen::SetLastSlash( get_site_url(), false ),
			'siteName' => \seraph_pds\Gen::GetSiteDisplayName(),
			'gmtOffset' => ( float )get_option( 'gmt_offset' ),
		) ) ) ), true ) );

		echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_mediaUploadUri', 'value' => \seraph_pds\Wp::GetMediaUploadUrl( null, true ) ), true ) );
		echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_helperRequestUrl', 'value' => Plugin::GetAdminApiUri() ), true ) );

		echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_postsAvailCats', 'value' => rawurlencode( wp_json_encode( GetPostsAvailableCategories( empty( $post ) ? null : array( $post -> post_type ) ) ) ) ), true ) );
		echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_availLangs', 'value' => rawurlencode( wp_json_encode( \seraph_pds\Wp::GetLangs() ) ) ), true ) );
		echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_googleDriveApiClientId', 'value' => $googleDriveApiClientId ), true ) );

		if( $mode == ShowOperateOptionsMode_Post )
		{
			echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_postType', 'value' => $postType ), true ) );

			echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_upload-post-url', 'value' => get_permalink( $post ) ), true ) );
			echo( \seraph_pds\Ui::TagOpen( 'input', array( 'type' => 'hidden', 'id' => 'seraph_pds_avail_plugins', 'value' => rawurlencode( wp_json_encode( $availablePlugins ) ) ), true ) );

			echo( \seraph_pds\Ui::InputBox( 'file', 'seraph_pds_upload', null, array( 'style' => array( 'display' => 'none' ), 'accept' => '.docx,.pdf', 'onchange' => 'seraph_pds_filename.value = this.files.length ? this.files[ 0 ].name : \'\';' ) ) );
		}

		echo( \seraph_pds\Ui::InputBox( 'file', 'seraph_pds_uploadMedias', null, array( 'multiple' => '', 'webkitdirectory' => '', 'style' => array( 'display' => 'none' ), 'onchange' => 'seraph_pds_uploadMediasPath.value = this.files.length ? seraph_pds.Gen.GetFileDir( this.files[ 0 ].webkitRelativePath, false, -1 ) : \'\';' ) ) );

		if( $mode == ShowOperateOptionsMode_Batch_Operate )
		{
			echo( \seraph_pds\Ui::InputBox( 'file', 'seraph_pds_upload', null, array( 'style' => array( 'display' => 'none' ), 'accept' => '.docx,.pdf', 'multiple' => '', 'onchange' => '' ) ) );
			echo( \seraph_pds\Ui::InputBox( 'file', 'seraph_pds_uploadDir', null, array( 'style' => array( 'display' => 'none' ), 'multiple' => '', 'webkitdirectory' => '', 'onchange' => '' ) ) );

		}
	}

	if( $mode == ShowOperateOptionsMode_Post || $mode == ShowOperateOptionsMode_Batch_Operate || $mode == ShowOperateOptionsMode_Settings )
	{
		echo( \seraph_pds\Ui::SettBlock_Begin( array( 'class' => array_merge( $settBlockClass, array( 'srcFilesArea', 'srcFilesShow_Local' ) ) ) ) );
		{
			echo( \seraph_pds\Ui::Tag( 'style', '.seraph_pds .srcFilesShow_GoogleDocs .srcFilesLocal, .seraph_pds .srcFilesShow_GoogleDocs .srcFilesGoogleDocsUrl{display:none;}.seraph_pds .srcFilesShow_GoogleDocsUrl .srcFilesLocal, .seraph_pds .srcFilesShow_GoogleDocsUrl .srcFilesGoogleDocs{display:none;}.seraph_pds .srcFilesShow_Local .srcFilesGoogleDocs, .seraph_pds .srcFilesShow_Local .srcFilesGoogleDocsUrl{display:none;}' ) );

			if( $mode == ShowOperateOptionsMode_Post || $mode == ShowOperateOptionsMode_Batch_Operate )
			{
				echo( \seraph_pds\Ui::SettBlock_Item_Begin( $mode == ShowOperateOptionsMode_Post ? ( _x( 'SrcFileLbl', 'admin.PostUpdater_Operation', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.' . ( _IsGutenbergPage() ? 'InplaceGtnbrgFileSource' : 'InplaceFileSource' ) ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) : ( _x( 'SrcFilesLbl', 'admin.PostUpdater_Operation_Direct', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.DirectFileSources' ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) ) );
				{
					echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => 'ctlSpaceVAfter' ) ) . \seraph_pds\Ui::TagOpen( 'tr' ) );
					{
						$radioGroupName = 'seraph_pds/srcFilesType';

						$defVal = 'Local';

						echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::RadioBox( _x( 'LocalRad', 'admin.PostUpdater_Operation_SrcType', 'seraphinite-post-docx-source' ), $radioGroupName, 'Local', $defVal == 'Local', null, null, array( 'onclick' => 'var area=jQuery(".seraph_pds .srcFilesArea");area.removeClass("srcFilesShow_GoogleDocs srcFilesShow_GoogleDocsUrl");area.addClass("srcFilesShow_Local");' ) ) ) );
						echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::RadioBox( _x( 'GoogleDocsRad', 'admin.PostUpdater_Operation_SrcType', 'seraphinite-post-docx-source' ), $radioGroupName, 'GoogleDocs', $defVal == 'GoogleDocs', null, null, array( 'onclick' => 'var area=jQuery(".seraph_pds .srcFilesArea");area.removeClass("srcFilesShow_Local srcFilesShow_GoogleDocsUrl");area.addClass("srcFilesShow_GoogleDocs");' ) ) ) );
						echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::RadioBox( _x( 'GoogleDocsUrlRad', 'admin.PostUpdater_Operation_SrcType', 'seraphinite-post-docx-source' ), $radioGroupName, 'GoogleDocsUrl', $defVal == 'GoogleDocsUrl', null, null, array( 'onclick' => 'var area=jQuery(".seraph_pds .srcFilesArea");area.removeClass("srcFilesShow_Local srcFilesShow_GoogleDocs");area.addClass("srcFilesShow_GoogleDocsUrl");' ) ) ) );
					}
					echo( \seraph_pds\Ui::TagClose( 'tr' ) . \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );

					echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => 'std srcFilesLocal', 'style' => array( 'width' => '100%' ) ) ) . \seraph_pds\Ui::TagOpen( 'tr' ) );
					{
						echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::Button( $mode == ShowOperateOptionsMode_Post ? _x( 'BrowseBtn', 'admin.PostUpdater_Operation', 'seraphinite-post-docx-source' ) : _x( 'BrowseAddBtn', 'admin.PostUpdater_Operation_Direct', 'seraphinite-post-docx-source' ), false, null, null, 'button', array( 'onclick' => 'seraph_pds_upload.click();', 'style' => array( 'min-width' => '7em' ) ) ), array( 'style' => array( 'width' => '1px' ) ) ) );
						if( $mode == ShowOperateOptionsMode_Post )
							echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::TextBox( 'seraph_pds_filename', null, array( 'style' => array( 'width' => '100%' ), 'readonly' => '' ) ) ) );
						else
							echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::Button( $mode == ShowOperateOptionsMode_Post ? _x( 'BrowseFolderBtn', 'admin.PostUpdater_Operation_Direct', 'seraphinite-post-docx-source' ) : _x( 'BrowseFolderAddBtn', 'admin.PostUpdater_Operation_Direct', 'seraphinite-post-docx-source' ), false, null, null, 'button', array( 'class' => array( 'showIfDirBrowseEnabled' ), 'onclick' => 'seraph_pds_uploadDir.click();' ) ) ) );
					}
					echo( \seraph_pds\Ui::TagClose( 'tr' ) . \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );

					echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => 'std srcFilesGoogleDocs', 'style' => array( 'width' => '100%' ) ) ) . \seraph_pds\Ui::TagOpen( 'tr' ) );
					{
						if( !empty( $googleDriveApiClientId ) )
						{
							echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::Button( $mode == ShowOperateOptionsMode_Post ? _x( 'BrowseBtn', 'admin.PostUpdater_Operation', 'seraphinite-post-docx-source' ) : _x( 'BrowseFileFolderAddBtn', 'admin.PostUpdater_Operation_Direct', 'seraphinite-post-docx-source' ), false, 'seraph_pds_uploadGoogleDocs', null, 'button', array( 'style' => array( 'min-width' => '7em' ) ) ), array( 'style' => array( 'width' => '1px' ) ) ) );

							echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::Tag( 'span', null, array( 'class' => array( 'seraph_pds_spinner' ), 'style' => array( 'vertical-align' => 'middle' ) ) ), array( 'id' => 'seraph_pds_googleDriveBrowsing', 'style' => array( 'display' => 'none', 'vertical-align' => 'middle', 'width' => $mode == ShowOperateOptionsMode_Post ? '1px' : null ) ) ) );
							if( $mode == ShowOperateOptionsMode_Post )
								echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::TextBox( 'seraph_pds_filenameGoogleDocs', null, array( 'style' => array( 'width' => '100%' ), 'readonly' => '' ) ) ) );
						}
						else
							echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::Tag( 'p', vsprintf( _x( 'GoogleDriveApiSetupNeededNotice_%1$s%2$s', 'admin.PostUpdater_Operation', 'seraphinite-post-docx-source' ), \seraph_pds\Ui::Link( array( '', '' ), Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.SettingsGoogleDriveApi' ), true ) ), array( 'class' => 'description' ) ) ) );
					}
					echo( \seraph_pds\Ui::TagClose( 'tr' ) . \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );

					echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => 'std srcFilesGoogleDocsUrl', 'style' => array( 'width' => '100%' ) ) ) . \seraph_pds\Ui::TagOpen( 'tr' ) );
					{
						if( $mode == ShowOperateOptionsMode_Batch_Operate )
							echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::Button( _x( 'AddBtn', 'admin.PostUpdater_Operation_Direct', 'seraphinite-post-docx-source' ), false, 'seraph_pds_uploadGoogleDocsUrl', null, 'button', array( 'style' => array( 'min-width' => '7em' ) ) ), array( 'style' => array( 'width' => '1px' ) ) ) );
						echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::InputBox( 'url', 'seraph_pds_fileUrlGoogleDocs', null, array( 'class' => array( 'ctlMaxSizeX' ), 'placeholder' => _x( 'SrcUrlGoogleDocsPlchldr', 'admin.PostUpdater_Operation', 'seraphinite-post-docx-source' ) ) ) ) );
					}
					echo( \seraph_pds\Ui::TagClose( 'tr' ) . \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );
				}
				echo( \seraph_pds\Ui::SettBlock_Item_End() );
			}

			if( $mode == ShowOperateOptionsMode_Post || $mode == ShowOperateOptionsMode_Batch_Operate )
			{
				echo( \seraph_pds\Ui::SettBlock_Item_Begin( _x( 'ExtMediaLbl', 'admin.PostUpdater_Operation', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.LinkedExternalMedia' ), \seraph_pds\Ui::AdminHelpBtnModeText ), array( 'class' => array( 'srcFilesLocal' ) ) ) );
				{
					echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => array( 'std', 'showIfDirBrowseEnabled' ), 'style' => array( 'width' => '100%' ) ) ) . \seraph_pds\Ui::TagOpen( 'tr' ) );
					{
						echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::Button( _x( 'BrowseMediaFolderBtn', 'admin.PostUpdater_Operation', 'seraphinite-post-docx-source' ), false, null, null, 'button', array( 'onclick' => 'seraph_pds_uploadMedias.click();' ) ), array( 'style' => array( 'width' => '1px' ) ) ) );
						echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::TextBox( 'seraph_pds_uploadMediasPath', null, array( 'style' => array( 'width' => '100%' ), 'readonly' => '' ) ), array( 'style' => array( 'width' => '100%' ) ) ) );
					}
					echo( \seraph_pds\Ui::TagClose( 'tr' )  . \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );

					echo( \seraph_pds\Ui::Tag( 'p', _x( 'ExtMediaNotice', 'admin.PostUpdater_Operation', 'seraphinite-post-docx-source' ), array( 'class' => array( 'description', 'hideIfDirBrowseEnabled' ) ) ) );
				}
				echo( \seraph_pds\Ui::SettBlock_Item_End() );
			}

			if( $mode == ShowOperateOptionsMode_Batch_Operate || $mode == ShowOperateOptionsMode_Settings )
			{
				echo( \seraph_pds\Ui::SettBlock_Item_Begin( $mode == ShowOperateOptionsMode_Settings ? _x( 'ContentTypeLbl', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) : ( _x( 'SrcFilesListLbl', 'admin.PostUpdater_Operation_Direct', 'seraphinite-post-docx-source' ) ) ) );
				{
					echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => 'std', 'style' => array( 'width' => '100%' ) ) ) );
					{
						echo( \seraph_pds\Ui::TagOpen( 'tr' ) );
						{
							echo( \seraph_pds\Ui::TagOpen( 'td' ) );
							{
?>

								<script>
									function seraph_pds_postType_Set( v )
									{
										jQuery( ".seraph_pds_settBlock" ).hide();
										jQuery( "#seraph_pds_settBlock_" + v ).show();
									}
								</script>

								<?php

								echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin() . \seraph_pds\Ui::TagOpen( 'tr' ) );
								{
									{
										$items = array();
										foreach( $aPostTypes as $postType )
											if( \seraph_pds\Gen::GetArrField( $sett, array( 'docTypes', $postType, 'enable' ), true ) )
												$items[ $postType ] = get_post_type_object( $postType ) -> labels -> name;

										echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::ComboBox( 'seraph_pds_postType', $items, 'post', false, array( 'style' => array( 'min-width' => '10em' ), 'onchange' => 'seraph_pds_postType_Set( this.selectedIndex >= 0 ? this.options[ this.selectedIndex ].value : \'\' );' ) ) ) );
									}

									if( $mode == ShowOperateOptionsMode_Batch_Operate )
										echo( \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::Button( _x( 'ClearListBtn', 'admin.PostUpdater_Operation_Direct', 'seraphinite-post-docx-source' ), false, 'seraph_pds_clearList', null, 'button', array( 'style' => array( 'min-width' => '7em' ) ) ), array( 'style' => array( 'width' => '1px' ) ) ) );
								}
								echo( \seraph_pds\Ui::TagClose( 'tr' ) . \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );
							}
							echo( \seraph_pds\Ui::TagClose( 'td' ) );
						}
						echo( \seraph_pds\Ui::TagClose( 'tr' ) );

						if( $mode == ShowOperateOptionsMode_Batch_Operate )
						{
							echo( \seraph_pds\Ui::TagOpen( 'tr' ) );
							{
								echo( \seraph_pds\Ui::TagOpen( 'td' ) );
								{
									echo( \seraph_pds\Ui::Tag( 'textarea', null, array( 'style' => array( 'width' => '100%', 'min-height' => '7em', 'max-height' => '30em' ), 'id' => 'seraph_pds_filenames', 'type' => 'text', 'readonly' => '' ) ) );
								}
								echo( \seraph_pds\Ui::TagClose( 'td' ) );
							}
							echo( \seraph_pds\Ui::TagClose( 'tr' ) );
						}
					}
					echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );
				}
				echo( \seraph_pds\Ui::SettBlock_Item_End() );
			}

			if( $mode == ShowOperateOptionsMode_Batch_Operate )
			{
				echo( \seraph_pds\Ui::SettBlock_Item_Begin( \seraph_pds\Wp::GetLocString( 'Status' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.PostStatus' ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) );
				{

					$postStatuses = get_post_statuses();

					$items = array();
					$items[ '' ] = \seraph_pds\Wp::GetLocString( '&mdash; No Change &mdash;' );
					foreach( $postStatuses as $postStatusId => $postStatus )
						$items[ $postStatusId ] = $postStatus;

					echo( \seraph_pds\Ui::ComboBox( 'seraph_pds_postStatus', $items, '', false ) );
				}
				echo( \seraph_pds\Ui::SettBlock_Item_End() );
			}
		}
		echo( \seraph_pds\Ui::SettBlock_End() );
	}

	if( $mode == ShowOperateOptionsMode_Post )
	{
		echo( \seraph_pds\Ui::SettBlock_Begin( array( 'class' => $settBlockClass ) ) );
		{
			echo( \seraph_pds\Ui::SettBlock_Item_Begin( _x( 'Title', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.PostInplaceOptSett' ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) );
			{
				echo( \seraph_pds\Ui::ToggleButton( 'seraph_pds_settBlock_' . $postType, array( 'style' => array( 'min-width' => '7em' ) ) ) );
			}
			echo( \seraph_pds\Ui::SettBlock_Item_End() );
		}
		echo( \seraph_pds\Ui::SettBlock_End() );

		_ShowOperateOptionsBlockForPostType( $mode, $postType, $postIsNew, $fileGuid, $rmtCfg, $rmtCfgFldCtx, $sett, $settBlockClass, $availablePlugins, $post, array( 'style' => array( 'display' => 'none' ) ) );
	}
	else if( $mode == ShowOperateOptionsMode_Settings || $mode == ShowOperateOptionsMode_Batch_Settings )
	{
		foreach( $aPostTypes as $postType )
			_ShowOperateOptionsBlockForPostType( $mode, $postType, $postIsNew, $fileGuid, $rmtCfg, $rmtCfgFldCtx, $sett, $settBlockClass, $availablePlugins );

		echo( \seraph_pds\Ui::Tag( 'script', 'seraph_pds_postType_Set( "' . ( empty( $aPostTypes ) ? '' : $aPostTypes[ 0 ] ) . '" );' ) );
	}

	if( $mode == ShowOperateOptionsMode_Post || $mode == ShowOperateOptionsMode_Batch_Operate )
	{
		echo( \seraph_pds\Ui::TagOpen( 'p' ) );
		{
			echo( _ShowOperateOptionsBlock_UpdateBtn( $mode == ShowOperateOptionsMode_Post ? _x( 'UpdateBtn', 'admin.PostUpdater_Operation', 'seraphinite-post-docx-source' ) : _x( 'UpdateAddBtn', 'admin.PostUpdater_Operation_Direct', 'seraphinite-post-docx-source' ), true, 'seraph_pds_reload', 'ctlSpaceAfter', 'button', array( 'style' => array( 'min-width' => '7em', 'vertical-align' => 'middle' ) ) ) );

			echo( \seraph_pds\Ui::Tag( 'span', null, array( 'id' => 'seraph_pds_loading', 'class' => array( 'seraph_pds_spinner' ), 'style' => array( 'display' => 'none', 'vertical-align' => 'middle' ) ) ) );
		}
		echo( \seraph_pds\Ui::TagClose( 'p' ) );
	}

	if( $mode == ShowOperateOptionsMode_Post || $mode == ShowOperateOptionsMode_Batch_Report )
	{
		echo( \seraph_pds\Ui::TagOpen( 'div' ) );
		{
			$heightMin = ( $mode == ShowOperateOptionsMode_Post ? '7' : '14' ) . 'em';

			if( $mode == ShowOperateOptionsMode_Post )
				echo( \seraph_pds\Ui::Tag( 'div', \seraph_pds\Ui::Tag( 'strong', _x( 'ReportLbl', 'admin.PostUpdater', 'seraphinite-post-docx-source' ) ), array( 'style' => array( 'margin-bottom' => '0.5em' ) ) ) );
			echo( _ShowOperateOptionsBlock_LogContent( \seraph_pds\Ui::Tag( 'div', null, array( 'id' => 'seraph_pds_messages', 'class' => 'seraph_pds_textarea', 'style' => array( 'overflow' => 'scroll', 'min-height' => $heightMin, 'height' => $heightMin, 'max-height' => ( ( $mode == ShowOperateOptionsMode_Post ? '100' : '500' ) . 'em' ), 'resize' => 'vertical' ) ) ) ) );
		}
		echo( \seraph_pds\Ui::TagClose( 'div' ) );
	}
}

function _ShowOperateOptionsBlockForPostType( $mode, $postType, $postIsNew, $fileGuid, $rmtCfg, $rmtCfgFldCtx, $sett, $settBlockClass, $availablePlugins, $post = null, $attrs = null )
{
	$isPaidLockedContent = Plugin::IsPaidLockedContent();

	$isLimitedMode = $isPaidLockedContent;
	$isLimitedModeInSettings = $mode == ShowOperateOptionsMode_Settings ? $isPaidLockedContent : false;
	$isLimitedModeInNotSettings = $mode != ShowOperateOptionsMode_Settings ? $isPaidLockedContent : false;

	$settBlockClass[] = 'seraph_pds_settBlock';
	$isLangsActive = \seraph_pds\Wp::IsLangsActive();

	echo( \seraph_pds\Ui::SettBlock_Begin( array_merge( is_array( $attrs ) ? $attrs : array(), array( 'id' => ( 'seraph_pds_settBlock_' . $postType ), 'class' => $settBlockClass ) ) ) );
	{
		echo( \seraph_pds\Ui::SettBlock_Item_Begin( _x( 'Lbl', 'admin.Settings_ContentConversion_Document', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminBtnsBlock( array( Plugin::AdminBtnsBlock_GetPaidContent( $isLimitedModeInSettings ) ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) );
		{
			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => array( 'ctlMaxSizeX' ) ) ) );

			{
				$fldId = 'docTypes/' . $postType . '/useSubjectAsID';
				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::CheckBox( _x( 'BindChk', 'admin.Settings_ContentConversion_Document', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.PostIdBinding' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ), 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, false, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) ) ) ) );
			}

			if( $mode == ShowOperateOptionsMode_Post )
			{
				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::TextBox( '_seraph_pds_BindGuid', $fileGuid, array( 'class' => array( 'ctlMaxSizeX' ), 'placeholder' => _x( 'BindGuidPlchldr', 'admin.Settings_ContentConversion_Document', 'seraphinite-post-docx-source' ) ), true ), array( 'style' => array( 'padding-left' => '1.5em' ) ) ) ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/useSeparateAttributes';
				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::CheckBox( _x( 'AttrsChk', 'admin.Settings_ContentConversion_Document', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.SeparateAttributes' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ), 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) ) ) ) );
			}

			{
				$rowAtrs = array();

				$ctlVal = \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' );

				if( !_IsGutenbergActive() )
				{
					$rowAtrs[ 'style' ] = array( 'display' => 'none' );
					$ctlVal = false;
				}

				if( ( $mode == ShowOperateOptionsMode_Post && !_IsGutenbergPage() ) || ( $mode == ShowOperateOptionsMode_Batch_Settings && !_IsGutenbergDefault( $postType ) ) )
					$ctlVal = false;

				$fldId = 'docTypes/' . $postType . '/useGtnbrgFormat';
				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::CheckBox( _x( 'GutenbergChk', 'admin.Settings_ContentConversion_Document', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.GtnbrgBodyBlocks' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ), 'seraph_pds/' . $fldId, $ctlVal, $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) ) ), $rowAtrs ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/useTextColors';
				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::CheckBox( _x( 'TextColorsChk', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.TextColors' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ), 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) ) ) ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/useFonts';
				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::CheckBox( _x( 'FontsChk', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.Fonts' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ), 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) ) ) ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/preserveEmptyParagraphs';
				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::CheckBox( _x( 'PreserveEmptyParagraphsChk', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.PreserveEmptyParagraphs' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ), 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) ) ) ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/useParagraphIndention';
				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td', \seraph_pds\Ui::CheckBox( _x( 'ParagraphIndentionChk', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.ParagraphIndention' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ), 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) ) ) ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/useNumberingStyle';
				$fldSubId = 'docTypes/' . $postType . '/useNumberingStyle_Mode';

				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td',
					\seraph_pds\Ui::CheckBox(
						array(
							_x( 'NumberingStyleChk_%1$s', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.NumberingStyle' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							array(
								array(
									'seraph_pds/' . $fldSubId,
									array(
										array( 'Fmt',			_x( 'NumberingStyleChk_1_Fmt',			'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
										array( 'Fmt,Tpl',		_x( 'NumberingStyleChk_1_FmtTpl',		'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
									),
									\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Fmt,Tpl', '/' )
								)
							)
						)
						, 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) )
				) ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/useParagraphSpacing';
				$fldSubId = 'docTypes/' . $postType . '/useParagraphSpacing_Mode';

				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td',
					\seraph_pds\Ui::CheckBox(
						array(
							_x( 'ParagraphSpacingChk_%1$s', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.ParagraphSpacing' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							array(
								array(
									'seraph_pds/' . $fldSubId,
									array(
										array( 'Body',			_x( 'ParagraphCmnChk_1_Body',			'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
										array( 'Style,Body',	_x( 'ParagraphCmnChk_1_StyleBody',		'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
										array( 'Style',			_x( 'ParagraphCmnChk_1_Style',			'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) )
									),
									\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Style,Body', '/' )
								)
							)
						)
						, 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) )
				) ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/useParagraphLineHeight';
				$fldSubId = 'docTypes/' . $postType . '/useParagraphLineHeight_Mode';

				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td',
					\seraph_pds\Ui::CheckBox(
						array(
							_x( 'ParagraphLineHeightChk_%1$s', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.ParagraphLineHeight' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							array(
								array(
									'seraph_pds/' . $fldSubId,
									array(
										array( 'Body',			_x( 'ParagraphCmnChk_1_Body',			'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
										array( 'Style,Body',	_x( 'ParagraphCmnChk_1_StyleBody',		'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
										array( 'Style',			_x( 'ParagraphCmnChk_1_Style',			'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) )
									),
									\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Style,Body', '/' )
								)
							)
						)
						, 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) )
				) ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/useParagraphTextFmt';
				$fldSubId = 'docTypes/' . $postType . '/useParagraphTextFmt_Mode';

				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td',
					\seraph_pds\Ui::CheckBox(
						array(
							_x( 'ParagraphTextFmtChk_%1$s', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.ParagraphTextFmt' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							array(
								array(
									'seraph_pds/' . $fldSubId,
									array(
										array( 'Body',			_x( 'ParagraphCmnChk_1_Body',			'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
										array( 'Style,Body',	_x( 'ParagraphCmnChk_1_StyleBody',		'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
										array( 'Style',			_x( 'ParagraphCmnChk_1_Style',			'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) )
									),
									\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Style,Body', '/' )
								)
							)
						)
						, 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) )
				) ) );
			}

			{
				$fldId = 'docTypes/' . $postType . '/useParagraphAttrs';
				$fldSubId = 'docTypes/' . $postType . '/useParagraphAttrs_Mode';

				echo( \seraph_pds\Ui::Tag( 'tr', \seraph_pds\Ui::Tag( 'td',
					\seraph_pds\Ui::CheckBox(
						array(
							_x( 'ParagraphAttrsChk_%1$s', 'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.ParagraphAttrs' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							array(
								array(
									'seraph_pds/' . $fldSubId,
									array(
										array( 'Body',			_x( 'ParagraphCmnChk_1_Body',			'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
										array( 'Style,Body',	_x( 'ParagraphCmnChk_1_StyleBody',		'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) ),
										array( 'Style',			_x( 'ParagraphCmnChk_1_Style',			'admin.Settings_ContentConversion', 'seraphinite-post-docx-source' ) )
									),
									\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Style,Body', '/' )
								)
							)
						)
						, 'seraph_pds/' . $fldId, \seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ), $mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings ) )
				) ) );
			}

			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );
		}
		echo( \seraph_pds\Ui::SettBlock_Item_End() );

		echo( \seraph_pds\Ui::SettBlock_Item_Begin( _x( 'Lbl', 'admin.Settings_ContentConversion_Links', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminBtnsBlock( array( array( 'type' => \seraph_pds\Ui::AdminBtn_Help, 'href' => Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.NonExistentLinks' ) ), Plugin::AdminBtnsBlock_GetPaidContent( $isLimitedModeInSettings ) ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) );
		{
			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin() );
			{
				$fldId = 'docTypes/' . $postType . '/notexistLinksAction'; $radioGroupName = 'seraph_pds/' . $fldId; $fldVal = \seraph_pds\Gen::GetArrField( $sett, $fldId, 'CheckOnly', '/' );

?>
				<tr>
					<td>
						<?php echo( \seraph_pds\Ui::RadioBox( _x( 'UnderlineChk', 'admin.Settings_ContentConversion_Links', 'seraphinite-post-docx-source' ), $radioGroupName, 'Underline', $fldVal == 'Underline', array( 'disabled' => $isLimitedModeInSettings ) ) ); ?>
					</td>
					<td>
						<?php echo( \seraph_pds\Ui::RadioBox( _x( 'CheckOnlyChk', 'admin.Settings_ContentConversion_Links', 'seraphinite-post-docx-source' ), $radioGroupName, 'CheckOnly', $fldVal == 'CheckOnly', array( 'disabled' => $isLimitedModeInSettings ) ) ); ?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo( \seraph_pds\Ui::RadioBox( _x( 'DelChk', 'admin.Settings_ContentConversion_Links', 'seraphinite-post-docx-source' ), $radioGroupName, 'Del', $fldVal == 'Del', array( 'disabled' => $isLimitedModeInSettings ) ) ); ?>
					</td>
					<td>
						<?php echo( \seraph_pds\Ui::RadioBox( _x( 'NoChk', 'admin.Settings_ContentConversion_Links', 'seraphinite-post-docx-source' ), $radioGroupName, 'No', $fldVal == 'No', array( 'disabled' => $isLimitedModeInSettings ) ) ); ?>
					</td>
				</tr>
				<?php
			}
			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );
		}
		echo( \seraph_pds\Ui::SettBlock_Item_End() );

		echo( \seraph_pds\Ui::SettBlock_Item_Begin( _x( 'Lbl', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminBtnsBlock( array( Plugin::AdminBtnsBlock_GetPaidContent( $isLimitedModeInSettings ) ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) );
		{
			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin() );
			{
				?>
				<tr>
					<td>
						<?php

						$fldId = 'docTypes/' . $postType . '/useTitle';
						$fldSubId = 'docTypes/' . $postType . '/useTitle_Mode';
						$fldExtractModeId = 'docTypes/' . $postType . '/useTitle_ExtractMode';

						echo( \seraph_pds\Ui::CheckBox(
							array(
								_x( 'TitleChk_%1$s%2$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminBtnsBlock( array( array( 'type' => \seraph_pds\Ui::AdminBtn_Help, 'href' => Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.Title' ) ), Plugin::AdminBtnsBlock_GetPaidContent( $isLimitedModeInNotSettings ) ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								array(
									array(
										'seraph_pds/' . $fldSubId,
										array(
											array( 'Body',			_x( 'TitleChk_1_Body',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop,Body',		_x( 'TitleChk_1_PropBody',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop',			_x( 'TitleChk_1_Prop',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Line1',			_x( 'TitleChk_1_Line1',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Line2',			_x( 'TitleChk_1_Line2',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Line3',			_x( 'TitleChk_1_Line3',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Line4',			_x( 'TitleChk_1_Line4',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Line5',			_x( 'TitleChk_1_Line5',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Line6',			_x( 'TitleChk_1_Line6',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Line7',			_x( 'TitleChk_1_Line7',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Line8',			_x( 'TitleChk_1_Line8',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Line9',			_x( 'TitleChk_1_Line9',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Line10',		_x( 'TitleChk_1_Line10',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										),
										\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Body', '/' )
									),

									array(
										'seraph_pds/' . $fldExtractModeId,
										array(
											array( '',				_x( 'TitleChk_2_Unchange',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'BodyDel',		_x( 'TitleChk_2_BodyDel',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
										),
										\seraph_pds\Gen::GetArrField( $sett, $fldExtractModeId, 'BodyDel', '/' )
									),
								)
							),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );
						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php

						$fldId = 'docTypes/' . $postType . '/useExcerpt';
						$fldSubId = 'docTypes/' . $postType . '/useExcerpt_Mode';

						echo( \seraph_pds\Ui::CheckBox(
							array(
								_x( 'ExcerptChk_%1$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.Excerpt' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								array(
									array(
										'seraph_pds/' . $fldSubId,
										array(
											array( 'Body',			_x( 'ExcerptChk_1_Body',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop,Body',		_x( 'ExcerptChk_1_PropBody',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop',			_x( 'ExcerptChk_1_Prop',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) )
										),
										\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Body', '/' )
									)
								)
							),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php

						$fldId = 'docTypes/' . $postType . '/useSlug';
						$fldSubId = 'docTypes/' . $postType . '/useSlug_Mode';

						echo( \seraph_pds\Ui::CheckBox(
							array(
								_x( 'SlugChk_%1$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.Slug' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								array(
									array(
										'seraph_pds/' . $fldSubId,
										array(
											array( 'Body',			_x( 'SlugChk_1_Body',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop,Body',		_x( 'SlugChk_1_PropBody',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop',			_x( 'SlugChk_1_Prop',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) )
										),
										\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Body', '/' )
									)
								)
							),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php

						$fldId = 'docTypes/' . $postType . '/useTags';
						$fldSubId = 'docTypes/' . $postType . '/useTags_Mode';

						echo( \seraph_pds\Ui::CheckBox(
							array(
								_x( 'TagsChk_%1$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.Tags' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								array(
									array(
										'seraph_pds/' . $fldSubId,
										array(
											array( 'Body',			_x( 'TagsChk_1_Body',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop,Body',		_x( 'TagsChk_1_PropBody',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop',			_x( 'TagsChk_1_Prop',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) )
										),
										\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Prop,Body', '/' )
									)
								)
							),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php

						$fldId = 'docTypes/' . $postType . '/useCategories';
						$fldSubId = 'docTypes/' . $postType . '/useCategories_Mode';

						echo( \seraph_pds\Ui::CheckBox(
							array(
								_x( 'CategoriesChk_%1$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.Categories' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								array(
									array(
										'seraph_pds/' . $fldSubId,
										array(
											array( 'Body',			_x( 'CategoriesChk_1_Body',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop,Body',		_x( 'CategoriesChk_1_PropBody',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop',			_x( 'CategoriesChk_1_Prop',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) )
										),
										\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Prop,Body', '/' )
									)
								)
							),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php

						$fldId = 'docTypes/' . $postType . '/useSeoTitle';
						$fldSubId = 'docTypes/' . $postType . '/useSeoTitle_Mode';

						echo( \seraph_pds\Ui::CheckBox(
							array(
								_x( 'SeoTitleChk_%1$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.SeoTitle' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								array(
									array(
										'seraph_pds/' . $fldSubId,
										array(
											array( 'Body',			_x( 'SeoTitleChk_1_Body',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop,Body',		_x( 'SeoTitleChk_1_PropBody',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop',			_x( 'SeoTitleChk_1_Prop',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) )
										),
										\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Prop,Body', '/' )
									)
								)
							),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<tr>
					<td>
						<?php

						$fldId = 'docTypes/' . $postType . '/useSeoDescription';
						$fldSubId = 'docTypes/' . $postType . '/useSeoDescription_Mode';

						echo( \seraph_pds\Ui::CheckBox(
							array(
								_x( 'SeoDescrChk_%1$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.SeoDescription' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								array(
									array(
										'seraph_pds/' . $fldSubId,
										array(
											array( 'Body',			_x( 'SeoDescrChk_1_Body',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop,Body',		_x( 'SeoDescrChk_1_PropBody',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop',			_x( 'SeoDescrChk_1_Prop',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) )
										),
										\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Prop,Body', '/' )
									)
								)
							),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<?php

				echo( \seraph_pds\Ui::TagOpen( 'tr' ) . \seraph_pds\Ui::TagOpen( 'td' ) );
				{
					$fldId = 'docTypes/' . $postType . '/useDate';
					$fldSubId = 'docTypes/' . $postType . '/useDate_Mode';
					$fldTzId = 'docTypes/' . $postType . '/useDate_Tz';
					$fldExtractModeId = 'docTypes/' . $postType . '/useDate_ExtractMode';

					echo( \seraph_pds\Ui::CheckBox(
						array(
							_x( 'DateChk_%1$s%2$s%3$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminBtnsBlock( array( array( 'type' => \seraph_pds\Ui::AdminBtn_Help, 'href' => Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.Date' ) ), Plugin::AdminBtnsBlock_GetPaidContent( $isLimitedModeInNotSettings ) ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							array(
								array(
									'seraph_pds/' . $fldSubId,
									array(
										array( 'Attr',			_x( 'DateChk_1_Attr',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
										array( 'Line1',			_x( 'DateChk_1_Line1',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										array( 'Line2',			_x( 'DateChk_1_Line2',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										array( 'Line3',			_x( 'DateChk_1_Line3',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										array( 'Line4',			_x( 'DateChk_1_Line4',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										array( 'Line5',			_x( 'DateChk_1_Line5',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										array( 'Line6',			_x( 'DateChk_1_Line6',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										array( 'Line7',			_x( 'DateChk_1_Line7',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										array( 'Line8',			_x( 'DateChk_1_Line8',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										array( 'Line9',			_x( 'DateChk_1_Line9',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										array( 'Line10',		_x( 'DateChk_1_Line10',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
									),
									$isLimitedMode ? 'Attr' : \seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Attr', '/' )
								),

								array(
									'seraph_pds/' . $fldTzId,
									array(
										array( '0',				\seraph_pds\Wp::GetLocString( 'UTC' ) ),
										array( 'Site',			_x( 'DateChk_2_Site',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
									),
									$isLimitedMode ? '0' : \seraph_pds\Gen::GetArrField( $sett, $fldTzId, '0', '/' )
								),

								array(
									'seraph_pds/' . $fldExtractModeId,
									array(
										array( '',				_x( 'DateChk_3_Unchange',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
										array( 'BodyDel',		_x( 'DateChk_3_BodyDel',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
									),
									\seraph_pds\Gen::GetArrField( $sett, $fldExtractModeId, 'BodyDel', '/' )
								),
							)
						),
						'seraph_pds/' . $fldId,
						\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
						$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
					) );
				}
				echo( \seraph_pds\Ui::TagClose( 'td' ) . \seraph_pds\Ui::TagClose( 'tr' ) );

?>
				<tr>
					<td>
						<?php

						$fldId = 'docTypes/' . $postType . '/useFeaturedImage';
						$fldSubId = 'docTypes/' . $postType . '/useFeaturedImage_Mode';

						echo( \seraph_pds\Ui::CheckBox(
							array(
								_x( 'FeaturedImageChk_%1$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminBtnsBlock( array( array( 'type' => \seraph_pds\Ui::AdminBtn_Help, 'href' => Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.FeaturedImage' ) ), Plugin::AdminBtnsBlock_GetPaidContent( $isLimitedModeInNotSettings ) ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								array(
									array(
										'seraph_pds/' . $fldSubId,
										array(
											array( 'Attr',			_x( 'FeaturedImageChk_1_Attr',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Attr,Body1',	_x( 'FeaturedImageChk_1_AttrBody1',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
											array( 'Body1',			_x( 'FeaturedImageChk_1_Body1',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), false, $isLimitedMode ),
										),
										$isLimitedMode ? 'Attr' : \seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Attr', '/' )
									)
								)
							),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<?php

				if( $isLangsActive )
				{
					echo( \seraph_pds\Ui::TagOpen( 'tr' ) . \seraph_pds\Ui::TagOpen( 'td' ) );
					{
						$fldId = 'docTypes/' . $postType . '/useLang';
						$fldSubId = 'docTypes/' . $postType . '/useLang_Mode';

						echo( \seraph_pds\Ui::CheckBox(
							array(
								_x( 'LangChk_%1$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.Lang' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								array(
									array(
										'seraph_pds/' . $fldSubId,
										array(
											array( 'Body',			_x( 'LangChk_1_Body',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop,Body',		_x( 'LangChk_1_PropBody',		'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) ),
											array( 'Prop',			_x( 'LangChk_1_Prop',			'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) )
										),
										\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'Body', '/' )
									)
								)
							),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );
					}
					echo( \seraph_pds\Ui::TagClose( 'td' ) . \seraph_pds\Ui::TagClose( 'tr' ) );

				}

				if( $postType == 'product' && @$availablePlugins[ 'woocommerce' ] && $mode != ShowOperateOptionsMode_Post )
				{
					echo( \seraph_pds\Ui::TagOpen( 'tr' ) . \seraph_pds\Ui::TagOpen( 'td' ) );
					{
						$fldId = 'docTypes/' . $postType . '/useWooGalleryImages';

						echo( \seraph_pds\Ui::CheckBox(
							_x( 'WooGalleryImagesChk', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.WooGalleryImages' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings,
							null
						) );
					}
					echo( \seraph_pds\Ui::TagClose( 'td' ) . \seraph_pds\Ui::TagClose( 'tr' ) );
				}

				{
					echo( \seraph_pds\Ui::TagOpen( 'tr' ) . \seraph_pds\Ui::TagOpen( 'td' ) );
					{
						$fldId = 'docTypes/' . $postType . '/useInplaceAttrs';

						echo( \seraph_pds\Ui::CheckBox(
								_x( 'CustomChk', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.OtherH1ExtAttrs' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								'seraph_pds/' . $fldId,
								\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
								$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						if( $mode == ShowOperateOptionsMode_Post && !_IsGutenbergPage() )
							echo( \seraph_pds\Ui::Tag( 'p', sprintf( _x( 'PageControlsForBlocksListInfo_%1$s', 'admin.Settings_ContentConversion_Attrs', 'seraphinite-post-docx-source' ), \seraph_pds\Ui::Tag( 'span', null, array( 'id' => 'seraph_pds/docTypes/' . $postType . '/useInplaceAttrsText' ) ) ), array( 'class' => 'description' ) ) );
					}
					echo( \seraph_pds\Ui::TagClose( 'td' ) . \seraph_pds\Ui::TagClose( 'tr' ) );
				}
			}
			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );
		}
		echo( \seraph_pds\Ui::SettBlock_Item_End() );

		echo( \seraph_pds\Ui::SettBlock_Item_Begin( _x( 'Lbl', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminBtnsBlock( array( array( 'type' => \seraph_pds\Ui::AdminBtn_Help, 'href' => Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.Media' ) ), Plugin::AdminBtnsBlock_GetPaidContent( $isLimitedModeInSettings ) ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) );
		{
			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin() );
			{
?>
				<tr>
					<td>
						<?php

						$fldId = 'docTypes/' . $postType . '/uploadMedia';

						echo( \seraph_pds\Ui::CheckBox(
							_x( 'UploadChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.UploadMedia' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<tr>
					<td style="padding-left:1.5em;">
						<?php

						$fldId = 'docTypes/' . $postType . '/uploadFromExtUrls';

						echo( \seraph_pds\Ui::CheckBox(
							_x( 'UploadFromExtUrlsChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.UploadMediaFromExtUrls' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, false, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<tr>
					<td style="padding-left:1.5em;">
						<?php

						$fldId = 'docTypes/' . $postType . '/uploadEmbed';

						echo( \seraph_pds\Ui::CheckBox(
							_x( 'EmbedChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.UploadMediaEmbed' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, false, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<tr>
					<td style="padding-left:1.5em;">
						<?php

						$fldId = 'docTypes/' . $postType . '/uploadOverwrite';

						echo( \seraph_pds\Ui::CheckBox(
							_x( 'OverwriteChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.UploadMediaOverwrite' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
							'seraph_pds/' . $fldId,
							\seraph_pds\Gen::GetArrField( $sett, $fldId, false, '/' ),
							$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
						) );

						?>
					</td>
				</tr>
				<tr>
					<td style="padding-left:1.5em;">
						<?php

						{
							$fldId = 'docTypes/' . $postType . '/uploadAsAttachments';

							echo( \seraph_pds\Ui::CheckBox(
								_x( 'PlaceToLibChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.PlaceIntoMediaLibrary' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								'seraph_pds/' . $fldId,
								\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
								$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
							) );
						}

						?>
					</td>
				</tr>

				<tr>
					<td style="padding-left:3em;">
						<?php

						{
							$subFldId = 'docTypes/' . $postType . '/imagesAsThumb';

							$items = array();
							{
								$aThumbnails = \seraph_pds\Wp::GetAvailableThumbnails();

								$items[] = array( '', _x( 'ImgSizeLbl_1_Original', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) );
								foreach( $aThumbnails as $thumbnailId => $thumbnail )
								{
									$cx = $thumbnail[ 'width' ];
									$cy = $thumbnail[ 'height' ];
									$items[] = array( $thumbnailId, $thumbnail[ 'name' ] . ' (' . ( $cx ? $cx : '*' ) . 'x' . ( $cy ? $cy : '*' ) .  ')' );
								}
							}

							echo( \seraph_pds\Ui::Label(
								array(
									_x( 'ImgSizeLbl_%1$s', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.ImgFilenameSize' ), \seraph_pds\Ui::AdminHelpBtnModeText ),
									array(
										array(
											'seraph_pds/' . $subFldId,
											$items,
											\seraph_pds\Gen::GetArrField( $sett, $subFldId, '', '/' )
										)
									)
								),
								$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
							) );
						}

						?>
					</td>
				</tr>

				<tr>
					<td style="padding-left:3em;">
						<?php

						{
							$fldSubId = 'docTypes/' . $postType . '/imageUseOrigSize';

							echo( \seraph_pds\Ui::Label(
								array(
									_x( 'ImgUseOrigSizeLbl_%1$s', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.ImgUseOrigSize' ), \seraph_pds\Ui::AdminHelpBtnModeText ),
									array(
										array(
											'seraph_pds/' . $fldSubId,
											array(
												array( 'No',				_x( 'ImgUseOrigSizeLbl_1_No',			'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) ),
												array( 'Link',				_x( 'ImgUseOrigSizeLbl_1_Link',			'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) ),
												array( 'LinkNewWnd',		_x( 'ImgUseOrigSizeLbl_1_LinkNewWnd',	'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) )
											),
											\seraph_pds\Gen::GetArrField( $sett, $fldSubId, 'No', '/' )
										)
									)
								),
								$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
							) );
						}

						?>
					</td>
				</tr>

				<tr>
					<td>
						<?php

						{
							$fldId = 'docTypes/' . $postType . '/imageUseDescrAsFilename';

							echo( \seraph_pds\Ui::CheckBox(
								_x( 'ImgDescrAsFileNameChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.MediaDescrAsFilename' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								'seraph_pds/' . $fldId,
								\seraph_pds\Gen::GetArrField( $sett, $fldId, false, '/' ),
								$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
							) );
						}

						?>
					</td>
				</tr>

				<tr>
					<td>
						<?php

						{
							$fldId = 'docTypes/' . $postType . '/mediaPrependSlugToFileName';

							echo( \seraph_pds\Ui::CheckBox(
								_x( 'PrependSlugToFileNamesChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.MediaPrependDocSlug' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
								'seraph_pds/' . $fldId,
								\seraph_pds\Gen::GetArrField( $sett, $fldId, false, '/' ),
								$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
							) );
						}

						?>
					</td>
				</tr>

				<?php

				echo( \seraph_pds\Ui::TagOpen( 'tr' ) . \seraph_pds\Ui::TagOpen( 'td' ) );
				{
					$fldId = 'docTypes/' . $postType . '/mediaFileNameToSlug';

					echo( \seraph_pds\Ui::CheckBox(
						_x( 'CnvFileNameToSlugChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.MediaCnvFileNameToSlug' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
						'seraph_pds/' . $fldId,
						\seraph_pds\Gen::GetArrField( $sett, $fldId, false, '/' ),
						$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
					) );
				}
				echo( \seraph_pds\Ui::TagClose( 'td' ) . \seraph_pds\Ui::TagClose( 'tr' ) );

				echo( \seraph_pds\Ui::TagOpen( 'tr' ) . \seraph_pds\Ui::TagOpen( 'td' ) );
				{
					$fldId = 'docTypes/' . $postType . '/useImageCrop';

					echo( \seraph_pds\Ui::CheckBox(
						_x( 'UseImageCropChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.MediaUseImageCrop' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
						'seraph_pds/' . $fldId,
						\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
						$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
					) );
				}
				echo( \seraph_pds\Ui::TagClose( 'td' ) . \seraph_pds\Ui::TagClose( 'tr' ) );

				echo( \seraph_pds\Ui::TagOpen( 'tr' ) . \seraph_pds\Ui::TagOpen( 'td' ) );
				{
					$fldId = 'docTypes/' . $postType . '/useImageResize';

					echo( \seraph_pds\Ui::CheckBox(
						_x( 'UseImageResizeChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.MediaUseImageResize' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
						'seraph_pds/' . $fldId,
						\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
						$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
					) );
				}
				echo( \seraph_pds\Ui::TagClose( 'td' ) . \seraph_pds\Ui::TagClose( 'tr' ) );

				echo( \seraph_pds\Ui::TagOpen( 'tr' ) . \seraph_pds\Ui::TagOpen( 'td' ) );
				{
					$fldId = 'docTypes/' . $postType . '/uploadImageCheckUrl';

					echo( \seraph_pds\Ui::CheckBox(
						_x( 'CheckUrlsChk', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.MediaCheckUrls' ), \seraph_pds\Ui::AdminHelpBtnModeChkRad ),
						'seraph_pds/' . $fldId,
						\seraph_pds\Gen::GetArrField( $sett, $fldId, true, '/' ),
						$mode == ShowOperateOptionsMode_Settings, array( 'disabled' => $isLimitedModeInSettings )
					) );
				}
				echo( \seraph_pds\Ui::TagClose( 'td' ) . \seraph_pds\Ui::TagClose( 'tr' ) );
			}
			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );

			if( $postIsNew )
				echo( \seraph_pds\Ui::Tag( 'p', vsprintf( _x( 'NewPostNoticeInfo_%1$s%2$s', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ), \seraph_pds\Ui::Tag( 'span', array( '', '' ) ) ), array( 'class' => 'description' ) ) );
		}
		echo( \seraph_pds\Ui::SettBlock_Item_End() );

		echo( \seraph_pds\Ui::SettBlock_Item_Begin( _x( 'MediaUrlLbl', 'admin.Settings_ContentConversion_Media', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminBtnsBlock( array( array( 'type' => \seraph_pds\Ui::AdminBtn_Help, 'href' => Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.MediaURLBase' ) ), Plugin::AdminBtnsBlock_GetPaidContent( $isLimitedModeInSettings ) ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) );
		{
			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => 'ctlMaxSizeX' ) ) );
			{
				if( $mode == ShowOperateOptionsMode_Post )
				{
					echo( \seraph_pds\Ui::TagOpen( 'tr' ) . \seraph_pds\Ui::TagOpen( 'td' ) );
					{
						echo( \seraph_pds\Ui::TextBox( 'seraph_pds_post-media-url', \seraph_pds\Wp::GetMediaUploadUrl( $post, true ), array( 'style' => array( 'width' => '100%' ) ) ) );
					}
					echo( \seraph_pds\Ui::TagClose( 'td' ) . \seraph_pds\Ui::TagClose( 'tr' ) );
				}

			}
			echo( \seraph_pds\Ui::SettBlock_ItemSubTbl_End() );
		}
		echo( \seraph_pds\Ui::SettBlock_Item_End() );

	}
	echo( \seraph_pds\Ui::SettBlock_End() );
}

function OnOptRead_Data( $data, $verFrom )
{
	return( $data );
}

function OnOptWrite_Data( $data )
{
	return( $data );
}

function OnOptRead_Sett( $sett, $verFrom )
{
	return( $sett );
}

function OnOptWritePrep_Sett( $sett )
{
	$postTypes = GetCompatiblePostsTypes();

	$atLeastOneEnabled = false;
	foreach( $postTypes as $postType )
		if( \seraph_pds\Gen::GetArrField( $sett, array( 'docTypes', $postType, 'enable' ), false ) )
			$atLeastOneEnabled = true;

	if( !$atLeastOneEnabled && count( $postTypes ) )
		\seraph_pds\Gen::SetArrField( $sett, array( 'docTypes', $postTypes[ 0 ], 'enable' ), true );

	return( $sett );
}

