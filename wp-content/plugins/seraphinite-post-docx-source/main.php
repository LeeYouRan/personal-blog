<?php

namespace seraph_pds;

if( !defined( 'ABSPATH' ) )
	exit;

require_once( __DIR__ . '/common.php' );
require_once( __DIR__ . '/helper.php' );

Plugin::Init();

add_action( 'wp_enqueue_scripts',
	function()
	{
		$sett = Plugin::SettGet();

		$formulasStylesLoadMode = Gen::GetArrField( $sett, 'formulas/view/initMode', 'Static', '/' );
		if( $formulasStylesLoadMode != 'No' )
		{
			if( $formulasStylesLoadMode == 'Static' )
				wp_enqueue_style( 'seraph-pds-MathJax-CHtml', Plugin::FileUri( 'Ext/MathJax/CHtml.css', __FILE__, true ), array(), '2.10.2' );
			wp_enqueue_script( Plugin::ScriptId( 'View' ), add_query_arg( Plugin::GetFileUrlPackageParams(), Plugin::FileUri( 'View.js', __FILE__, true ) ), array(), '2.10.2' );
		}
	}
);

function OnActivate()
{
}

function OnDeactivate()
{
}

function OnInitAdminMode()
{
	add_action( 'admin_init',
		function()
		{
			if( isset( $_POST[ 'seraph_pds_saveSettings' ] ) )
			{
				unset( $_POST[ 'seraph_pds_saveSettings' ] );
				Plugin::ReloadWithPostOpRes( array( 'saveSettings' => _OnSaveSettings( $_POST ) ) );
				exit;
			}

			if( defined( 'WP_LOAD_IMPORTERS' ) )
				register_importer( 'seraph_pds_import', Plugin::GetPluginString( 'TitleFull' ), Plugin::GetPluginString( 'Description' ), 'seraph_pds\\_UploadPage' );

			add_editor_style( '../../plugins/seraphinite-post-docx-source/Ext/MathJax/CHtml.css' );
		}
	);

	add_action( 'seraph_pds_postOpsRes',
		function( $res )
		{
			if( ( $hr = @$res[ 'saveSettings' ] ) !== null )
				echo( Plugin::Sett_SaveResultBannerMsg( $hr, Ui::MsgOptDismissible ) );

		}
	);

	add_action( 'add_meta_boxes',
		function()
		{
			$rmtCfg = PluginRmtCfg::Get();
			$sett = Plugin::SettGet();

			$urlHelp = Plugin::RmtCfgFld_GetLoc( $rmtCfg, 'Help.' . ( _IsGutenbergPage() ? 'PostInplaceGtnbrgUpdater' : 'PostInplaceUpdater' ) );

			foreach( GetCompatiblePostsTypes() as $postType )
			{
				if( !Gen::GetArrField( $sett, array( 'docTypes', $postType, 'enable' ), true ) )
					continue;

				Ui::MetaboxAdd(
					'seraph_pds_postUpdater',
					Plugin::GetPluginString( 'Title' ) . Ui::Tag( 'span', Ui::AdminHelpBtn( $urlHelp, Ui::AdminHelpBtnModeBlockHeader ) ),
					'seraph_pds\\_OnPostBox', null,
					$postType, 'normal', 'high'
				);
			}
		}
	);

	add_action( 'admin_menu',
		function()
		{
			add_options_page( Plugin::GetSettingsTitle(), Plugin::GetNavMenuTitle(), 'manage_options', 'seraph_pds_settings', 'seraph_pds\\_SettingsPage' );
			add_menu_page( Plugin::GetPluginString( 'TitleLong' ), Plugin::GetNavMenuTitle(), 'publish_posts', 'seraph_pds_main', 'seraph_pds\\_UploadPage', Plugin::FileUri( 'icon.png?v=2.10.2', __FILE__ ) );
		}
	);

	add_action( 'save_post', 'seraph_pds\\_OnPostSettingsSave' );
}

function _OnPostBox( $post )
{
	_LoadScripts();

	$htmlContent = Plugin::SwitchToExt();
	if( !empty( $htmlContent ) )
		echo( Ui::Tag( 'p', $htmlContent ) . Ui::SepLine( 'p' ) );

	$htmlContent = Plugin::GetLockedFeatureLicenseContent();
	if( !empty( $htmlContent ) )
		echo( Ui::Tag( 'p', $htmlContent ) . Ui::SepLine( 'p' ) );

	echo( Ui::Tag( 'script', 'var seraph_pds_GbrgEditorIsActive = ' . ( _IsGutenbergPage() ? 'true' : 'false' ) . ';' ) );

	wp_nonce_field( 'savePostSettings', 'seraph_pds/_nonce' );

	_ShowOperateOptions( ShowOperateOptionsMode_Post, $post );
}

function _OnPostSettingsSave( $postId )
{
	if( !current_user_can( 'edit_post', $postId ) )
		return;

	if( !wp_verify_nonce( @$_REQUEST[ 'seraph_pds/_nonce' ], 'savePostSettings' ) )
		return;

	SetPostBindGuid( $postId, @$_REQUEST[ '_seraph_pds_BindGuid' ] );
}

function _SettingsPage()
{
	_LoadScripts( false );

	Plugin::DisplayAdminFooterRateItContent();

	$rmtCfg = PluginRmtCfg::Get();

	$sett = Plugin::SettGet();

	{
		Ui::PostBoxes_MetaboxAdd( 'general', _x( 'Title', 'admin.Settings_General', 'seraphinite-post-docx-source' ) . Ui::Tag( 'span', Ui::AdminHelpBtn( Plugin::RmtCfgFld_GetLoc( $rmtCfg, 'Help.Settings' ), Ui::AdminHelpBtnModeBlockHeader ) ), true,
			function( $callbacks_args, $box )
			{
				extract( $box[ 'args' ] );

				{
					$switchHtmlContent = Plugin::SwitchToExt();
					if( !empty( $switchHtmlContent ) )
						echo( Ui::Tag( 'p', $switchHtmlContent ) . Ui::SepLine( 'p' ) );
					unset( $switchHtmlContent );
				}

				echo( Ui::SettBlock_Begin() );
				{
					echo( Ui::SettBlock_Item_Begin( _x( 'ContentTypesLbl', 'admin.Settings_General', 'seraphinite-post-docx-source' ) ) );
					{
						echo( Ui::SettBlock_ItemSubTbl_Begin() );
						{
							echo( Ui::TagOpen( 'tr' ) );
							{
								$i = 0;
								foreach( GetCompatiblePostsTypes() as $postType )
								{
									if( $i && !( $i % 3 ) )
										echo( Ui::TagClose( 'tr' ) . Ui::TagOpen( 'tr' ) );

									$fldId = 'docTypes/' . $postType . '/enable';

									echo( Ui::TagOpen( 'td' ) );
									{
										echo( Ui::CheckBox( get_post_type_object( $postType ) -> labels -> name, 'seraph_pds/' . $fldId, Gen::GetArrField( $sett, $fldId, true, '/' ), true ) );
									}
									echo( Ui::TagClose( 'td' ) );

									$i++;
								}
							}
							echo( Ui::TagClose( 'tr' ) );
						}
						echo( Ui::SettBlock_ItemSubTbl_End() );

						echo( Ui::Tag( 'p', _x( 'ContentTypesDsc', 'admin.Settings_General', 'seraphinite-post-docx-source' ), array( 'class' => array( "description" ) ) ) );
					}
					echo( Ui::SettBlock_Item_End() );

					echo( Ui::SettBlock_Item_Begin( _x( 'FormulasLbl', 'admin.Settings_General', 'seraphinite-post-docx-source' ) ) );
					{
						echo( Ui::SettBlock_ItemSubTbl_Begin( array( 'class' => 'ctlSpaceVAfter1' ) ) . Ui::TagOpen( 'tr' ) );
						{
							$fldId = 'formulas/view/initMode'; $radioGroupName = 'seraph_pds/' . $fldId; $fldVal = Gen::GetArrField( $sett, $fldId, 'Static', '/' );

							echo( Ui::Tag( 'td', Ui::RadioBox( _x( 'StaticEnm', 'admin.Settings_Formulas_InitMode', 'seraphinite-post-docx-source' ), $radioGroupName, 'Static', $fldVal == 'Static' ) ) );
							echo( Ui::Tag( 'td', Ui::RadioBox( _x( 'DynamicEnm', 'admin.Settings_Formulas_InitMode', 'seraphinite-post-docx-source' ), $radioGroupName, 'Dynamic', $fldVal == 'Dynamic' ) ) );
							echo( Ui::Tag( 'td', Ui::RadioBox( _x( 'NoEnm', 'admin.Settings_Formulas_InitMode', 'seraphinite-post-docx-source' ), $radioGroupName, 'No', $fldVal == 'No' ) ) );
						}
						echo( Ui::TagClose( 'tr' ) . Ui::SettBlock_ItemSubTbl_End() );
					}
					echo( Ui::SettBlock_Item_End() );

					echo( Ui::SettBlock_Item_Begin( _x( 'GoogleDriveApiLbl', 'admin.Settings_General', 'seraphinite-post-docx-source' ) . \seraph_pds\Ui::AdminBtnsBlock( array( array( 'type' => \seraph_pds\Ui::AdminBtn_Help, 'href' => Plugin::RmtCfgFld_GetLocEx( $rmtCfgFldCtx, $rmtCfg, 'Help.SettingsGoogleDriveApi' ) ) ), \seraph_pds\Ui::AdminHelpBtnModeText ) ) );
					{
						echo( Ui::SettBlock_ItemSubTbl_Begin() . Ui::TagOpen( 'tr' ) );
						{
							$fldId = 'google/apiDrive/clientId';
							echo( Ui::TextBox( 'seraph_pds/' . $fldId, Gen::GetArrField( $sett, $fldId, '', '/' ), array( 'style' => array( 'width' => '100%' ) ), true ) );
						}
						echo( Ui::TagClose( 'tr' ) . Ui::SettBlock_ItemSubTbl_End() );
					}
					echo( Ui::SettBlock_Item_End() );
				}
				echo( Ui::SettBlock_End() );
			},
			get_defined_vars()
		);

	}

	{
		$htmlContent = Plugin::GetSettingsLicenseContent();
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'license', Plugin::GetSettingsLicenseTitle(), true, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'normal' );

		$htmlContent = Plugin::GetAdvertProductsContent( 'advertProducts' );
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'advertProducts', Plugin::GetAdvertProductsTitle(), false, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'normal' );

	}

	{
		$htmlContent = Plugin::GetRateItContent( 'rateIt', Plugin::DisplayContent_SmallBlock );
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'rateIt', Plugin::GetRateItTitle(), false, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'side' );

		$htmlContent = Plugin::SwitchToExt( Plugin::DisplayContent_SmallBlock );
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'switchToExt', Plugin::GetSwitchToExtTitle(), false, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'side' );

		$htmlContent = Plugin::GetLockedFeatureLicenseContent( Plugin::DisplayContent_SmallBlock );
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'switchToFull', Plugin::GetSwitchToFullTitle(), false, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'side' );

		Ui::PostBoxes_MetaboxAdd( 'about', Plugin::GetAboutPluginTitle(), false, function( $callbacks_args, $box ) { echo( Plugin::GetAboutPluginContent() ); }, null, 'side' );
		Ui::PostBoxes_MetaboxAdd( 'aboutVendor', Plugin::GetAboutVendorTitle(), false, function( $callbacks_args, $box ) { echo( Plugin::GetAboutVendorContent() ); }, null, 'side' );
	}

	Ui::PostBoxes( Plugin::GetSettingsTitle(), array( 'body' => array( 'nosort' => true ), 'normal' => array(), 'side' => array( 'nosort' => true ) ),
		array(
			'bodyContentBegin' => function( $callbacks_args )
			{
				extract( $callbacks_args );

				echo( Ui::TagOpen( 'form', array( 'method' => 'post' ) ) );
			},

			'bodyContentEnd' => function( $callbacks_args )
			{
				extract( $callbacks_args );

				Ui::PostBoxes_BottomGroupPanel(
					function( $callbacks_args )
					{
						echo( Plugin::Sett_SaveBtn( 'seraph_pds_saveSettings' ) );
					}
				);

				echo( Ui::TagClose( 'form' ) );
			}
		),
		get_defined_vars()
	);
}

function _OnSaveSettings( $args )
{
	$sett = Plugin::SettGet();

	foreach( GetCompatiblePostsTypes() as $postType )
	{
		$fldId = 'docTypes/' . $postType . '/enable';
		Gen::SetArrField( $sett, $fldId, isset( $args[ 'seraph_pds/' . $fldId ] ), '/' );

	}

	{
		$fldId = 'formulas/view/initMode';
		Gen::SetArrField( $sett, $fldId, $args[ 'seraph_pds/' . $fldId ], '/' );
	}

	{
		$fldId = 'google/apiDrive/clientId';
		Gen::SetArrField( $sett, $fldId, $args[ 'seraph_pds/' . $fldId ], '/' );
	}

	return( Plugin::SettSet( $sett ) );
}

function _UploadPage()
{
	_LoadScripts();

	Plugin::DisplayAdminFooterRateItContent();

	$rmtCfg = PluginRmtCfg::Get();

	$htmlContent = Plugin::SwitchToExt( Plugin::DisplayContent_Block, vsprintf( _x( 'SwitchToExtInfo_%1$s%2$s%3$s%4$s', 'admin.PostDirectUpdater', 'seraphinite-post-docx-source' ), Gen::ArrFlatten( array( Ui::Link( Ui::Tag( 'strong', array( '', '' ) ), Plugin::RmtCfgFld_GetLoc( $rmtCfg, 'Help.PostDirectUpdater' ), true ), Ui::Tag( 'strong', array( '', '' ) ) ) ) ) );
	if( !empty( $htmlContent ) )
		Ui::PostBoxes_MetaboxAdd( 'switchToExt', Plugin::GetSwitchToExtTitle(), false, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ) );

	{
		$htmlContent = Plugin::GetAdvertProductsContent( 'advertProducts' );
		if( !empty( $htmlContent ) )
			Ui::PostBoxes_MetaboxAdd( 'advertProducts', Plugin::GetAdvertProductsTitle(), false, function( $callbacks_args, $box ) { echo( $box[ 'args' ][ 'c' ] ); }, array( 'c' => $htmlContent ), 'normal' );
	}

	Ui::PostBoxes( sprintf( _x( 'Title_%1$s', 'admin.PostDirectUpdater', 'seraphinite-post-docx-source' ), Plugin::GetPluginString( 'TitleLong' ) ), array( 'body' => array( 'nosort' => true ), 'normal' => array() ),
		array(
			'header' => function( $callbacks_args )
			{
				extract( $callbacks_args );

				{
					$bannerCmnContent = '<strong class="title"></strong><p class="body"></p>';
					echo( Ui::BannerMsg( Ui::MsgSucc, $bannerCmnContent, 0, array( 'id' => 'seraph_pds_TotalSucc', 'style' => array( 'display' => 'none' ) ) ) );
					echo( Ui::BannerMsg( Ui::MsgWarn, $bannerCmnContent, 0, array( 'id' => 'seraph_pds_TotalWarn', 'style' => array( 'display' => 'none' ) ) ) );
				}

			}
		),
		get_defined_vars(),
		array( 'wrap' => array( 'id' => 'seraph_pds_batchUpdater' ) )
	);
}

function _LoadScripts( $workScript = true )
{

	echo( Plugin::CmnScripts( array( 'Cmn', 'Gen', 'Ui', 'Net' ) ) );

	if( !$workScript )
		return;

	wp_register_script( Plugin::ScriptId( 'editor' ), add_query_arg( Plugin::GetFileUrlPackageParams(), Plugin::FileUri( 'editor.js', __FILE__, true ) ), array_merge( array( 'jquery' ), Plugin::CmnScriptId( array( 'Cmn', 'Gen', 'Ui', 'Net' ) ) ), '2.10.2' );
	Plugin::Loc_ScriptLoad( Plugin::ScriptId( 'editor' ) );
	wp_enqueue_script( Plugin::ScriptId( 'editor' ) );

}

