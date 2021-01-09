<?php

namespace seraph_pds;

if( !defined( 'ABSPATH' ) )
	exit;

class Ui
{

	static function Link( $content, $href, $newWnd = false, $prms = null, $attrs = null )
	{
		if( $attrs === null )
			$attrs = array();

		$showLink = !empty( $href ) || @$prms[ 'showIfNoHref' ];

		if( $showLink )
		{
			$resPart = '';

			$linkPreContent = @$prms[ 'linkPreContent' ];
			if( $linkPreContent )
				$resPart .= $linkPreContent;

			if( !empty( $href ) )
			{
				$attrs[ 'href' ] = $href;

				if( $newWnd && strpos( $href, 'mailto:' ) !== 0 )
					$attrs[ 'target' ] = '_blank';
			}

			$resPart .= Ui::TagOpen( 'a', $attrs );

			if( is_array( $content ) )
				$content[ 0 ] = $resPart . $content[ 0 ];
			else
				$content = $resPart . $content;
		}
		else if( @$prms[ 'noTextIfNoHref' ] )
		{
			if( !is_array( $content ) )
				return( '' );

			$content[ 0 ] = '';
			$content[ count( $content ) - 1 ] = '';
			if( count( $content ) == 3 )
				$content[ 1 ] = '';

			return( $content );
		}

		if( $showLink )
		{
			$resPart = Ui::TagClose( 'a' );

			$linkAfterContent = @$prms[ 'linkAfterContent' ];
			if( $linkAfterContent )
				$resPart .= $linkAfterContent;

			if( is_array( $content ) )
				$content[ count( $content ) - 1 ] .= $resPart;
			else
				$content .= $resPart;
		}

		return( $content );
	}

	static function Label( $text, $addNames = false, $attrs = null )
	{
		if( !is_array( $attrs ) )
			$attrs = array();

		if( is_array( $text ) && count( $text ) == 2 )
		{
			$txtItems = $text[ 1 ];
			$txtArgs = array();

			$attrsForCombo = array( 'class' => array( 'inline' ), 'disabled' => @$attrs[ 'disabled' ] );

			foreach( $txtItems as $txtItem )
			{
				if( !is_array( $txtItem ) )
				{
					$txtArgs[] = $txtItem;
					continue;
				}

				$switchOptions = array();

				$switchDefVal = null;
				if( isset( $txtItem[ 2 ] ) )
					$switchDefVal = $txtItem[ 2 ];

				foreach( $txtItem[ 1 ] as $txtItemVal )
				{
					if( isset( $txtItemVal[ 2 ] ) && $txtItemVal[ 2 ] )
						$switchDefVal = $txtItemVal[ 0 ];

					$itemAttrs = array();
					if( isset( $txtItemVal[ 3 ] ) && $txtItemVal[ 3 ] )
						$itemAttrs[ 'disabled' ] = true;
					$switchOptions[ $txtItemVal[ 0 ] ] = array( $txtItemVal[ 1 ], $itemAttrs );
				}

				$txtArgs[] = self::ComboBox( $txtItem[ 0 ], $switchOptions, $switchDefVal, $addNames, $attrsForCombo );
			}

			$text = vsprintf( $text[ 0 ], $txtArgs );
		}

		return( self::Tag( 'label', $text, $attrs ) );
	}

	static function CheckBox( $text, $id, $checked = false, $addNames = false, $attrs = null, $title = null, $checkAttrs = null )
	{
		if( !is_array( $checkAttrs ) )
			$checkAttrs = array();

		if( $id )
			$checkAttrs[ 'id' ] = $id;

		return( self::_CheckRadBox( 'checkbox', $text, $checkAttrs, null, $checked, $addNames, $attrs, $title ) );
	}

	static function RadioBox( $text, $idGroup, $value, $def = false, $attrs = null, $title = null, $radioAttrs = null )
	{
		if( !is_array( $radioAttrs ) )
			$radioAttrs = array();

		if( $idGroup )
			$radioAttrs[ 'name' ] = $idGroup;

		return( self::_CheckRadBox( 'radio', $text, $radioAttrs, $value, $def, false, $attrs, $title ) );
	}

	static private function _CheckRadBox( $type, $text, $attrs, $value = null, $checked = false, $addNames = false, $attrsForLabel = null, $title = null )
	{
		if( !is_array( $attrs ) )
			$attrs = array();
		if( !is_array( $attrsForLabel ) )
			$attrsForLabel = array();

		$attrs[ 'disabled' ] = @$attrsForLabel[ 'disabled' ];

		if( !empty( $title ) )
			$attrs[ 'title' ] = $attrsForLabel[ 'title' ] = $title;

		if( !empty( $checked ) )
			$attrs[ 'checked' ] = 'checked';

		$res = self::InputBox( $type, null, $value, $attrs, $addNames );

		if( is_array( $text ) && count( $text ) == 2 )
			$text[ 0 ] = $res . $text[ 0 ];
		else
			$text = $res . $text;

		return( self::Label( $text, $addNames, $attrsForLabel ) );
	}

	static function ComboBox( $id, $items, $value, $addNames = false, $attrs = null )
	{
		if( !is_array( $attrs ) )
			$attrs = array();
		if( !is_array( $items ) )
			$items = array();

		self::_AddIdName( $attrs, $id, $addNames );

		$res = '';

		foreach( $items as $itemVal => $itemText )
		{
			$itemAttrs = null;
			if( is_array( $itemText ) )
			{
				$itemAttrs = $itemText[ 1 ];
				$itemText = $itemText[ 0 ];
			}

			if( !is_array( $itemAttrs ) )
				$itemAttrs = array();

			$itemAttrs[ 'value' ] = $itemVal;
			if( $itemVal == $value )
				$itemAttrs[ 'selected' ] = '';

			$res .= self::Tag( 'option', $itemText, $itemAttrs );
		}

		return( self::Tag( 'select', $res, $attrs ) );
	}

	static function TextBox( $id, $value = null, $attrs = null, $addNames = false )
	{
		return( self::InputBox( 'text', $id, $value, $attrs, $addNames ) );
	}

	static function NumberBox( $id, $value = null, $attrs = null, $addNames = false )
	{
		return( self::InputBox( 'number', $id, $value, $attrs, $addNames ) );
	}

	static function EscHtml( $value, $spaces = false )
	{
		if( Gen::DoesFuncExist( 'esc_html' ) )
			$value = esc_html( $value );
		else
		{
			$value = str_replace( '&', '&amp;', $value );
			$value = str_replace( '"', '&quot;', $value );
			$value = str_replace( '\'', '&#039;', $value );
			$value = str_replace( '<', '&lt;', $value );
			$value = str_replace( '>', '&gt;', $value );
		}

		if( $spaces )
			$value = str_replace( ' ', '&nbsp;', $value );

		return( $value );
	}

	private static function _AddIdName( &$attrs, $id, $addNames )
	{
		if( !empty( $id ) )
			$attrs[ 'id' ] = $id;
		else
			$id = @$attrs[ 'id' ];

		if( !empty( $id ) && $addNames )
		{
			$attrs[ 'name' ] = $id;
			if( $addNames == 'n' )
				unset( $attrs[ 'id' ] );
		}
	}

	private static function _GetTagAttrs( $attrs )
	{
		$res = '';

		if( is_array( $attrs ) )
		{
			foreach( $attrs as $attr => $attrVal )
			{
				if( $attr === 'disabled' )
				{
					if( $attrVal !== true && $attrVal !== '' )
						continue;
					$attrVal = '';
				}

				$res .= ' ' . $attr;

				if( $attrVal === '' )
					continue;

				$res .= '="';

				if( is_array( $attrVal ) )
				{
					if( $attr == "style" )
					{
						foreach( $attrVal as $attrValItem => $attrValItemVal )
							if( $attrValItemVal !== null )
								$res .= $attrValItem . ':' . $attrValItemVal . ';';
					}
					else
					{
						$first = true;
						foreach( $attrVal as $attrValItem )
						{
							if( empty( $attrValItem ) )
								continue;

							if( !$first )
								$res .= ' ';
							$res .= $attrValItem;

							$first = false;
						}
					}
				}
				else
					$res .= self::EscHtml( $attrVal );

				$res .= '"';
			}
		}
		else if( is_string( $attrs ) )
			$res .= ' ' . $attrs;

		return( $res );
	}

	static function InputBox( $type, $id, $value = null, $attrs = null, $addNames = false )
	{
		if( !is_array( $attrs ) )
			$attrs = array();

		$attrs[ 'type' ] = $type;

		self::_AddIdName( $attrs, $id, $addNames );

		if( !empty( $value ) )
			$attrs[ 'value' ] = $value;

		return( self::Tag( 'input', null, $attrs, true ) );
	}

	static function Button( $content, $primary = false, $nameId = null, $classesEx = null, $type = 'submit', $attrs = null )
	{
		$res = '';

		$isBtnEx = ( $type == 'button' ) && ( strpos( $content, '<' ) !== false );

		if( !$attrs )
			$attrs = array();

		if( $nameId )
			Gen::SetArrField( $attrs, 'name', $nameId );

		Gen::SetArrField( $attrs, 'type', $type );
		if( !$isBtnEx )
		{
			Gen::SetArrField( $attrs, 'value', $content );
			$content = null;
		}

		Gen::SetArrField( $attrs, 'class.+', 'button' );
		if( $primary )
			Gen::SetArrField( $attrs, 'class.+', 'button-primary' );

		if( $classesEx )
		{
			if( is_array( $classesEx ) )
			{
				foreach( $classesEx as $c )
					Gen::SetArrField( $attrs, 'class.+', $c );
			}
			else
				Gen::SetArrField( $attrs, 'class.+', $classesEx );
		}

		return( Ui::Tag( $isBtnEx ? 'button' : 'input', $content, $attrs ) );
	}

	static function Comment( $content = null )
	{
		return( '<!-- ' . $content . ' -->' );
	}

	static function Spinner( $big = false, array $attrs = null )
	{
		if( !$attrs )
			$attrs = array();
		Gen::SetArrField( $attrs, 'class.+', 'seraph_pds_spinner' . ( $big ? ' big' : '' ) );
		return( Ui::Tag( 'span', null, $attrs ) );
	}

	static function ToggleButton( $idItemToToggle, $attrsBtn = null, $attrs = null )
	{
		if( !$attrsBtn )
			$attrsBtn = array();
		if( !$attrs )
			$attrs = array();

		Gen::SetArrField( $attrsBtn, 'style.line-height', '0' );
		Gen::SetArrField( $attrsBtn, 'style.vertical-align', 'middle' );
		Gen::SetArrField( $attrsBtn, 'onclick', 'seraph_pds.Ui._cb.ToggleButton_OnClick("' . $idItemToToggle . '",this);return(false);' );

		return( Ui::Tag( 'div', Ui::Button( Ui::Tag( 'span', null, array( 'class' => 'dashicons dashicons-arrow-down', 'style' => array( 'margin-left' => '-0.1em' ) ) ), false, null, null, 'button', $attrsBtn ) . Ui::Spinner( false, array( 'class' => array( 'ctlSpaceBefore' ), 'style' => array( 'display' => 'none', 'vertical-align' => 'middle' ) ) ), $attrs ) );
	}

	static function Tag( $name, $content = null, $attrs = null, $selfClose = false, $prms = null )
	{
		if( $content === null )
			$content = '';

		if( @$prms[ 'noTagsIfNoContent' ] && empty( $content ) )
			return( $content );

		$resPart = self::TagOpen( $name, $attrs, $selfClose );
		if( $selfClose )
			return( $resPart );

		if( is_array( $content ) )
			$content[ 0 ] = $resPart . $content[ 0 ];
		else
			$content = $resPart . $content;

		$resPart = self::TagClose( $name );

		if( is_array( $content ) )
			$content[ count( $content ) - 1 ] .= $resPart;
		else
			$content .= $resPart;

		return( $content );
	}

	static function TagOpen( $name, $attrs = null, $selfClose = false )
	{
		if( empty( $name ) )
			return( '' );
		return( '<' . $name . self::_GetTagAttrs( $attrs ) . ( $selfClose ? ' /' : '' ) . '>' );
	}

	static function TagClose( $name )
	{
		if( empty( $name ) )
			return( '' );
		return( '</' . $name . '>' );
	}

	static function TokensList( $value, $id = null, $attrs = null, $addNames = false )
	{
		$res = '';

		if( $attrs === null )
			$attrs = array();

		$attrsVal = array( 'type' => 'hidden', 'value' => @rawurlencode( @wp_json_encode( $value ) ) );

		self::_AddIdName( $attrs, $id, $addNames );
		if( @$attrs[ 'name' ] )
		{
			$attrsVal[ 'name' ] = @$attrs[ 'name' ];
			unset( $attrs[ 'name' ] );
		}

		Gen::SetArrField( $attrs, 'class.+', 'seraph_pds_TokensList seraph_pds_textarea rs' );
		Gen::SetArrField( $attrs, 'style.overflow', 'scroll' );
		Gen::SetArrField( $attrs, 'style.resize', 'vertical' );

		return( Ui::Tag( 'div', Ui::TagOpen( 'input', $attrsVal, true ), $attrs ) );
	}

	static function TokensList_GetVal( $value )
	{
		$a = @json_decode( @rawurldecode( $value ), true );
		return( is_array( $a ) ? $a : array() );
	}

	static function ItemsList( array $prms, array $items, $idItems, $cbItem, $cbEmpty, $cbArgs = null, $attrs = null, $level = 0 )
	{
		$res = '';

		$onDelItemJsCb = @$prms[ 'onDelItemJsCb' ];
		$sortable = @$prms[ 'sortable' ];

		if( $cbEmpty )
			$res .= call_user_func( $cbEmpty, $cbArgs, array( 'class' => 'items-list-empty-content', 'style' => empty( $items ) ? array() : array( 'display' => 'none' ) ) );

		if( !$attrs )
			$attrs = array();

		Gen::SetArrField( $attrs, 'class.+', 'items-list' );

		Gen::SetArrField( $attrs, 'style.list-style-type', 'none' );
		Gen::SetArrField( $attrs, 'style.margin', 0 );
		Gen::SetArrField( $attrs, 'style.padding', 0 );
		if( empty( $items ) )
			Gen::SetArrField( $attrs, 'style.display', 'none' );

		$res .= Ui::TagOpen( 'ul', $attrs );

		$contentItemBegin = explode( '{{itemKey}}', Ui::TagOpen( 'li', array( 'class' => 'item {{itemKey}}' . ( $sortable ? ' ui-sortable-handle' : '' ), 'style' => array( 'margin' => 0, 'padding' => 0 ) ) ) );
		$contentItemEnd = Ui::TagClose( 'li' );

		$initCount = 0;
		$itemsLimit = @$prms[ 'itemsLimit' ];
		foreach( $items as $itemKey => $item )
		{
			if( $itemsLimit !== null && $initCount > $itemsLimit )
				break;

			$res .= $contentItemBegin[ 0 ] . $itemKey . $contentItemBegin[ 1 ] . call_user_func( $cbItem, $cbArgs, $idItems, $items, $itemKey, $item ) . $contentItemEnd;
			$initCount++;
		}

		$res .= Ui::TagClose( 'ul' );

		ob_start();

		$itemIdTpl = '{{' . $level . 'itemId}}';

		?>
		
		<script>
			jQuery( document ).ready(
				function( $ )
				{
					seraph_pds.Ui.ItemsList._Init( "<?php echo( $prms[ 'editorAreaCssPath' ] ); ?>", <?php echo( empty( $onDelItemJsCb ) ? 'null' : $onDelItemJsCb ); ?>, <?php echo( $initCount ); ?>, "<?php echo( Gen::GetJsHtmlContent( $contentItemBegin[ 0 ] . $itemIdTpl . $contentItemBegin[ 1 ] . call_user_func( $cbItem, $cbArgs, $idItems, null, $itemIdTpl, null ) . $contentItemEnd ) ); ?>", <?php echo( $sortable ? 'true' : 'false' ); ?>, <?php echo( $level ) ?> );
				}
			);
		</script>

		<?php

		$res .= ob_get_clean();

		return( $res );
	}

	static function ItemsList_GetItemCssPath( $itemKey )
	{
		return( '.items-list .item.' . $itemKey );
	}

	static function ItemsList_ItemOperateBtnsTpl( array $prms, $attrs = null )
	{

		if( !$attrs )
			$attrs = array();

		$res = '';

		if( @$prms[ 'sortable' ] )
		{
			$res .= Ui::Button( Ui::Tag( 'span', null, array( 'class' => 'dashicons dashicons-arrow-up', 'style' => array( 'display' => 'table-cell' ) ) ), false, null, null, 'button', array_merge( $attrs, Gen::GetArrField( $prms, 'btnsItemOperate.up.attrs', array() ) ) );
			$res .= Ui::Button( Ui::Tag( 'span', null, array( 'class' => 'dashicons dashicons-arrow-down', 'style' => array( 'display' => 'table-cell' ) ) ), false, null, null, 'button', array_merge( $attrs, Gen::GetArrField( $prms, 'btnsItemOperate.down.attrs', array() ) ) );
		}

		$res .= Ui::Button( Ui::Tag( 'span', null, array( 'class' => 'dashicons dashicons-trash', 'style' => array( 'display' => 'table-cell' ) ) ), false, null, null, 'button', array_merge( $attrs, Gen::GetArrField( $prms, 'btnsItemOperate.del.attrs', array() ) ) );

		return( $res );
	}

	static function ItemsList_ItemOperateBtns( array $prms, $attrs = null )
	{
		Gen::SetArrField( $prms, 'btnsItemOperate.up.attrs.onclick', 'seraph_pds.Ui.ItemsList.MoveItem(\'' . $prms[ 'editorAreaCssPath' ] . '\',this,-1);return false;' );
		Gen::SetArrField( $prms, 'btnsItemOperate.down.attrs.onclick', 'seraph_pds.Ui.ItemsList.MoveItem(\'' . $prms[ 'editorAreaCssPath' ] . '\',this,1);return false;' );
		Gen::SetArrField( $prms, 'btnsItemOperate.del.attrs.onclick', 'seraph_pds.Ui.ItemsList.DelItem(\'' . $prms[ 'editorAreaCssPath' ] . '\',this);return false;' );
		return( self::ItemsList_ItemOperateBtnsTpl( $prms, $attrs ) );
	}

	static function ItemsList_OperateBtnsTpl( array $prms, $attrs = null )
	{
		if( !$attrs )
			$attrs = array();

		$res = '';

		$res .= Ui::Button( _x( 'AddItemBtn', 'admin.Common_ItemsList', 'seraphinite-post-docx-source' ), false, null, null, 'button', array_merge( $attrs, Gen::GetArrField( $prms, 'btnsOperate.add.attrs', array() ) ) );
		$res .= Ui::Button( _x( 'DelAllItemsBtn', 'admin.Common_ItemsList', 'seraphinite-post-docx-source' ), false, null, null, 'button', array_merge( $attrs, Gen::GetArrField( $prms, 'btnsOperate.delAll.attrs', array() ) ) );

		return( $res );
	}

	static function ItemsList_OperateBtns( array $prms, $attrs = null )
	{
		Gen::SetArrField( $prms, 'btnsOperate.add.attrs.onclick', 'seraph_pds.Ui.ItemsList.AddItem(\'' . $prms[ 'editorAreaCssPath' ] . '\',this);return false;' );
		Gen::SetArrField( $prms, 'btnsOperate.delAll.attrs.onclick', 'seraph_pds.Ui.ItemsList.DelAllItems(\'' . $prms[ 'editorAreaCssPath' ] . '\',this);return false;' );
		return( self::ItemsList_OperateBtnsTpl( $prms, $attrs ) );
	}

	static function ItemsList_NoItemsContent( $attrs = null )
	{
		return( Ui::Tag( 'span', _x( 'NoItemsInfo', 'admin.Common_ItemsList', 'seraphinite-post-docx-source' ), $attrs ) );
	}

	static function ItemsList_GetSaveItems( $idItems, $sep, $request, $cbItem = null, $cbArgs = null )
	{
		$rearrange = false;

		$keyItemsPrefix = $idItems . $sep;

		$resTmp = array();
		foreach( $request as $k => $v )
		{
			if( strpos( $k, $keyItemsPrefix ) !== 0 )
				continue;

			$itemKey = substr( $k, strlen( $keyItemsPrefix ) );

			$posNextPath = strpos( $itemKey, $sep );
			if( $posNextPath !== false )
			{
				$itemKey = substr( $itemKey, 0, $posNextPath );
				$v = null;
			}

			if( !@$resTmp[ $itemKey ] )
			{
				$resTmp[ $itemKey ] = $cbItem ? call_user_func( $cbItem, $cbArgs, $idItems, $itemKey, $v, $request ) : ( $v !== null ? $v : true );
				if( is_numeric( $itemKey ) )
					$rearrange = true;
			}
		}

		if( !$rearrange )
			return( $resTmp );

		$res = array();
		foreach( $resTmp as $k => $v )
			$res[] = $v;

		return( $res );
	}

	static function MetaboxAdd( $id, $title, $callback, $callbacks_args = null, $screen = null, $context = 'advanced', $priority = 'default', $classesAdd = null, $classesRemove = null )
	{
		return( self::_MetaboxAdd( $id, $title, $callback, $callbacks_args, $screen, $context, $priority, array( 'seraph_pds', $classesAdd ), $classesRemove ) );
	}

	static private $g_aMetaBox_Classes = null;

	static private function _MetaboxAdd( $id, $title, $callback, $callbacks_args = null, $screen = null, $context = 'advanced', $priority = 'default', $classesAdd = null, $classesRemove = null )
	{
		if( is_string( $classesAdd ) )
			$classesAdd = array( $classesAdd );
		else if( !is_array( $classesAdd ) )
			$classesAdd = array();

		if( is_string( $classesRemove ) )
			$classesRemove = array( $classesRemove );
		else if( !is_array( $classesRemove ) )
			$classesRemove = array();

		$key = 'postbox_classes_' . get_current_screen() -> id . '_' . $id;

		self::$g_aMetaBox_Classes[ $key ] = array( 'a' => $classesAdd, 'r' => $classesRemove );

		add_meta_box( $id, Ui::Tag( 'span', $title ), $callback, $screen, $context, $priority, $callbacks_args );

		add_filter( $key,
			function( $classes )
			{
				$metaBox_Classes = self::$g_aMetaBox_Classes[ current_filter() ];

				foreach( $metaBox_Classes[ 'r' ] as $class )
					if( ( $classKey = array_search( $class, $classes ) ) !== false )
						unset( $classes[ $classKey ] );

				foreach( $metaBox_Classes[ 'a' ] as $class )
					if( array_search( $class, $classes ) === false )
						$classes[] = $class;

				return( $classes );
			}
		);
	}

	static function PostBoxes_BottomGroupPanel( $callback, $callbacks_args = null )
	{
		echo( Ui::TagOpen( 'div' ) );
		call_user_func( $callback, array( $callback_args ) );
		echo( Ui::TagClose( 'div' ) );
	}

	static function PostBoxes_MetaboxAdd( $id, $title, $expandable = true, $callback = null, $callbacks_args = null, $context = 'body', $classesAdd = null, $classesRemove = null )
	{
		if( is_string( $classesAdd ) )
			$classesAdd = array( $classesAdd );
		else if( !is_array( $classesAdd ) )
			$classesAdd = array();

		if( is_string( $classesRemove ) )
			$classesRemove = array( $classesRemove );
		else if( !is_array( $classesRemove ) )
			$classesRemove = array();

		if( !$expandable )
		{
			$classesAdd[] = 'nocollapse';
			$classesRemove[] = 'closed';
		}

		return( self::_MetaboxAdd( $id, $title, $callback, $callbacks_args, null, $context, 'default', $classesAdd, $classesRemove ) );
	}

	static function PostBoxes( $title, $metaBoxes = array( 'body' => null ), array $callbacks = null, $callbacks_args = null, $blocksAttrs = null )
	{
		wp_enqueue_script( 'postbox' );

		{
			$dropBoxes = array();
			foreach( $metaBoxes as $metaBoxId => $metaBox )
				if( $metaBox && @$metaBox[ 'nosort' ] )
					$dropBoxes[] = $metaBoxId;

			if( count( $dropBoxes ) )
			{
				$userId = get_current_user_id();
				$userOptId = 'meta-box-order_' . get_current_screen() -> id;

				$sorted = get_user_option( $userOptId, $userId );
				$modified = false;
				foreach( $dropBoxes as $dropBoxId )
				{
					if( isset( $sorted[ $dropBoxId ] ) )
					{
						unset( $sorted[ $dropBoxId ] );
						$modified = true;
					}
				}

				if( $modified )
					update_user_option( $userId, $userOptId, $sorted );
			}
		}

		$modeClass = '';
		if( isset( $metaBoxes[ 'side' ] ) )
			$modeClass = ' columns-2';
		else if( isset( $metaBoxes[ 'normal' ] ) )
			$modeClass = ' columns-1';

		if( $blocksAttrs === null )
			$blocksAttrs = array();

		Gen::SetArrField( $blocksAttrs, 'wrap.class.+', 'wrap' );
		Gen::SetArrField( $blocksAttrs, 'wrap.class.+', 'seraph_pds' );

		?>

		<div<?php echo( self::_GetTagAttrs( $blocksAttrs[ 'wrap' ] ) ); ?>">
			<h1><?php echo( $title ); ?></h1>

			<?php

				$cbHeader = @$callbacks[ 'header' ];
				if( $cbHeader )
					call_user_func( $cbHeader, array( $callback_args ) );

				wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );
				wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
			?>

			<div id="poststuff">
				<div id="post-body" class="metabox-holder<?php echo( $modeClass ); ?>">
					<div id="post-body-content">
						<?php

						{
							$cb = @$callbacks[ 'bodyContentBegin' ];
							if( $cb )
								call_user_func( $cb, array( $callback_args ) );
						}

						{
							{
								$cb = @$callbacks[ 'body' ];
								if( $cb )
									call_user_func( $cb, array( $callback_args ) );
							}

							{
								if( isset( $metaBoxes[ 'body' ] ) )
									do_meta_boxes( '', 'body', null );
							}
						}

						{
							$cb = @$callbacks[ 'bodyContentEnd' ];
							if( $cb )
								call_user_func( $cb, array( $callback_args ) );
						}

						?>
					</div>

					<?php if( isset( $metaBoxes[ 'side' ] ) ) { ?>
						<div id="postbox-container-1" class="postbox-container">
							<?php do_meta_boxes( '', 'side', null ); ?>
						</div>
					<?php } ?>

					<?php if( isset( $metaBoxes[ 'normal' ] ) ) { ?>
						<div id="postbox-container-2" class="postbox-container">
							<?php do_meta_boxes( '', 'normal', null ); ?>
						</div>
					<?php } ?>
				</div><!-- #post-body -->
			</div><!-- #poststuff -->

		</div><!-- .wrap -->

		<script>
			jQuery( document ).on( 'ready',
				function( $ )
				{
					postboxes.add_postbox_toggles( pagenow );

					var ctlMetaboxHolder = jQuery( "#post-body.metabox-holder" );
					<?php

					foreach( $metaBoxes as $metaBoxId => $metaBox )
					{
						if( !$metaBox || !@$metaBox[ 'nosort' ] )
							continue;

					?>_MetaboxesBlock_DisableSortable( ctlMetaboxHolder, "<?php echo( $metaBoxId ); ?>" );
					<?php

					}

					?>

					jQuery( ".postbox.nocollapse" ).each(
						function()
						{
							var e = jQuery( this );
							e.find( ".hndle" ).unbind( "click" );
							e.find( ".handlediv" ).remove();
						}
					);

					function _MetaboxesBlock_DisableSortable( ctlMetaboxHolder, id )
					{
						var ctl = ctlMetaboxHolder.find( "#" + id + "-sortables" );
						ctl.sortable( "disable" );
						ctl.addClass( "nosort" );
					}
				}
			);
		</script>

		<?php
	}

	static function PostBoxes_Popup( $id, $title, $callback = null, $callbacks_args = null )
	{
		$boxId = 'seraph_pds_popup_' . $id;
		$popupSide = $boxId . '_container';

		self::PostBoxes_MetaboxAdd( $boxId, $title, false, $callback, $callbacks_args, $popupSide );
		do_meta_boxes( '', $popupSide, $callbacks_args );

        ?>

		<script>
			(function()
			{
				var popupId = "#<?php echo( $boxId ); ?>";
				var block = jQuery( "#<?php echo( $boxId ); ?>" );
				
				var closeBtn = block.find( ".handlediv" );
				closeBtn.html( "" );
				closeBtn.addClass( "notice-dismiss" );
				closeBtn.removeClass( "handlediv" );
				closeBtn.css( "position", "relative" );

				closeBtn.on( "click", function(){ seraph_pds.Ui.PopupClose( "<?php echo( $id ); ?>" ); } );
			})();
		</script>
		
		<?php
	}

	static function SettBlock_Begin( $attrs = null )
	{
		if( $attrs === null )
			$attrs = array();

		Gen::SetArrField( $attrs, 'class.+', 'form-table' );
		Gen::SetArrField( $attrs, 'class.+', 'settings' );

		return( Ui::TagOpen( 'table', $attrs ) . Ui::TagOpen( 'tbody' ) );
	}

	static function SettBlock_End()
	{
		return( Ui::TagClose( 'tbody' ) . Ui::TagClose( 'table' ) );
	}

	static function SettBlock_Item_Begin( $label, $attrs = null )
	{
		if( $attrs === null )
			$attrs = array();

		$attrs[ 'valign' ] = 'top';

		$res = '';

		$res .= '<tr ' . self::_GetTagAttrs( $attrs ) . '>';
		$res .= '<th scope="row">' . $label . '</th>';
		$res .= '<td>';
		$res .= '<fieldset>';

		return( $res );
	}

	static function SettBlock_Item_End()
	{
		$res = '';

		$res .= '</fieldset></td></tr>';

		return( $res );
	}

	static function SettBlock_ItemSubTbl_Begin( $attrs = null )
	{
		if( !$attrs )
			$attrs = array();

		Gen::SetArrField( $attrs, 'class.+', 'sub' );
		Gen::SetArrField( $attrs, 'border', '0' );
		Gen::SetArrField( $attrs, 'cellpadding', '0' );
		Gen::SetArrField( $attrs, 'cellspacing', '0' );

		return( Ui::TagOpen( 'table', $attrs ) . Ui::TagOpen( 'tbody' ) );
	}

	static function SettBlock_ItemSubTbl_End()
	{
		return( Ui::TagClose( 'tbody' ) . Ui::TagClose( 'table' ) );
	}

	const MsgInfo					= 0;
	const MsgSucc					= 1;
	const MsgWarn					= 2;
	const MsgErr					= 3;

	const MsgOptDismissible			= 0x00000001;
	const MsgOptFade				= 0x00000002;

	static function BannerMsg( $severity, $text, $opts = 0, $attrs = NULL )
	{
		if( empty( $text ) )
			return( '' );

		if( !is_array( $attrs ) )
			$attrs = array();

		$class = '';
		switch( $severity )
		{
			case Ui::MsgSucc:		$class .= 'notice notice-success'; break;
			case Ui::MsgWarn:		$class .= 'notice notice-warning'; break;
			case Ui::MsgErr:		$class .= 'notice notice-error'; break;

			default:				$class .= 'notice notice-info'; break;
		}

		if( $opts & Ui::MsgOptDismissible )
			$class .= ' is-dismissible';
		if( $opts & Ui::MsgOptFade )
			$class .= ' fade';

		Gen::SetArrField( $attrs, 'class.+', $class );

		$res = Ui::TagOpen( 'div', $attrs );

		$res .= '<div class="seraph_pds"><p class="content">' . $text . '</p></div>';

		$res .= Ui::TagClose( 'div' );

		return( $res );
	}

	const AdminHelpBtnModeBlockHeader		= 'blkhdr';
	const AdminHelpBtnModeChkRad			= 'chkrad';
	const AdminHelpBtnModeText				= 'txt';
	const AdminHelpBtnModeBtn				= 'btn';

	const AdminBtn_Help						= 'dashicons-editor-help';
	const AdminBtn_Paid						= 'dashicons-admin-network';

	static function AdminBtnsBlock( $items, $mode )
	{
		$res = '';

		foreach( $items as $item )
		{
			if( $item === null )
				continue;

			$newWnd = @$item[ 'newWnd' ];
			if( $newWnd === null )
				$newWnd = true;

			$prms = array();
			$linkParams = \apply_filters( 'seraph_pds_Ui_AdminBtnsBlock_Link', array( 'content' => null, 'attrs' => array( 'class' => array( 'dashicons', $item[ 'type' ] ) ) ), $item[ 'type' ] );

			if( $item[ 'type' ] == Ui::AdminBtn_Paid )
				$prms[ 'showIfNoHref' ] = true;
			else
				$prms[ 'noTextIfNoHref' ] = true;

			$res .= Ui::Link( $linkParams[ 'content' ], @$item[ 'href' ], $newWnd, array( 'noTextIfNoHref' => true ), $linkParams[ 'attrs' ] );
		}

		return( Ui::Tag( 'span', Ui::Tag( 'span', $res, array( 'class' => array( $mode ) ) ), array( 'class' => array( 'mbtns' ) ) ) );
	}

	static function AdminHelpBtn( $href, $mode = Ui::AdminHelpBtnModeText, $newWnd = true )
	{
		return( Ui::AdminBtnsBlock( array( array( 'type' => Ui::AdminBtn_Help, 'href' => $href, 'newWnd' => $newWnd ) ), $mode ) );
	}

	static function SepLine( $tag = 'div', $attrs = null )
	{
		if( !$attrs )
			$attrs = array();
		Gen::SetArrField( $attrs, 'class.+', 'hndle postbox-header' );
		return( Ui::Tag( $tag, null, $attrs ) );
	}

	static function Script( $src, $ver = null, $attrs = null )
	{
		if( !$attrs )
			$attrs = array();
		$attrs[ 'type' ] = 'text/javascript';
		$attrs[ 'src' ] = empty( $ver ) ? $src : add_query_arg( array( 'v' => $ver ), $src );
		return( Ui::Tag( 'script', null, $attrs ) );
	}

	static function ScriptInline( $src, $ver = null, $attrs = null )
	{
		return( Ui::ScriptInlineContent( @file_get_contents( $src ), $ver, $attrs ) );
	}

	static function ScriptInlineContent( $content, $ver = null, $attrs = null )
	{
		if( !$attrs )
			$attrs = array();
		if( !isset( $attrs[ 'type' ] ) )
			$attrs[ 'type' ] = 'text/javascript';
		return( Ui::Tag( 'script', $content, $attrs ) );
	}

	static function Style( $src, $ver = null, $attrs = null )
	{
		if( !$attrs )
			$attrs = array();
		$attrs[ 'href' ] = empty( $ver ) ? $src : add_query_arg( array( 'v' => $ver ), $src );
		$attrs[ 'rel' ] = 'stylesheet';
		return( Ui::Tag( 'link', null, $attrs, true ) );
	}

	static function StyleInline( $src, $ver = null, $attrs = null )
	{

		return( Ui::Tag( 'style', @file_get_contents( $src ), $attrs ) );
	}
}

class UiPopups
{
	static private $items = NULL;

	static function Add( $id, $prms )
	{
		self::$items[ $id ] = $prms;
	}

	static function Draw()
	{
		if( empty( self::$items ) )
			return;

		$needModal = false;
		foreach( self::$items as $id => $prms )
		{
			if( $prms[ 'modal' ] )
				$needModal = true;

			if( $prms[ 'cbPre' ] )
				call_user_func( $prms[ 'cbPre' ], array( $prms ) );

			$attrs = $prms[ 'attrs' ];
			if( !$attrs )
				$attrs = array();

			ob_start();
			call_user_func( $prms[ 'cb' ], $id, $prms );
			$body = ob_get_clean();

			$attrs[ 'id' ] = 'seraph_pds_popup_' . $id;
			$attrs[ 'style' ][ 'display' ] = 'none';
			$attrs[ 'attr-modal' ][ 'display' ] = $prms[ 'modal' ];
			$attrs[ 'attr-body' ] = rawurlencode( $body );

			Gen::SetArrField( $attrs, 'class.+', 'seraph_pds popup' );

			echo( Ui::Tag( 'div', null, $attrs ) );
		}

		if( $needModal )
			echo( Ui::Tag( 'div', null, array( 'class' => 'seraph_pds popup_modal_overlay', 'style' => array( 'display' => 'none' ) ) ) );
	}
}

