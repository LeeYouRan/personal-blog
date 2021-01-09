<?php
defined( 'ABSPATH' ) OR exit;


if( isset( $_POST['anylink-rules-submit'] ) && $_POST['anylink-rules-submit'] == 'Y' ){
    check_admin_referer( 'anylink_rules' );
    anylink_save_rules();
}
    
function anylink_save_rules(){
    global $pagenow;
    $rules = get_option( 'anylink_options' );
    if( $pagenow == 'options-general.php' && $_GET['page'] == 'anyLinkSetting' ){
        if( isset( $rules['rules'] ) ){
            $rules['rules'] = explode( "\n",$_POST['anylink_rule'] );
            $rules['rules'] = array_map( 'sanitize_text_field', $rules['rules'] );
        } else {
            $rules['rules'] = '';
        }
        update_option( 'anylink_options', $rules );
    }
}
?>
<div class="wrap">
	<div id="icon-link-manager" class="icon32"></div><h2><?php _e( 'anylink Settings', 'anylink' ); ?></h2>
    <?php
        $tab= isset( $_GET['tab' ]) ? $_GET['tab'] : 'general';
        alAdminTab( $tab );
        switch( $tab ){
            case 'general' :
            echo '<form action="options.php?tab='.$tab .'" method="post">';
            settings_fields( 'anylink_options_group' ); 
            do_settings_sections( 'anyLinkSetting' ); 
            submit_button();
            echo '</form>';
        break;
        case 'rules' :             
    ?>
        <form action="options-general.php?page=anyLinkSetting&tab=rules" method="post">
            <?php wp_nonce_field( 'anylink_rules' ); ?>
            <H3><?php _e( 'URL whitelist', 'anylink' ); ?></H3>
            <textarea class="large-text code" rows="12" id="anylink_rule" name="anylink_rule">
<?php
                $anylink_rules = get_option( 'anylink_options' );
                if( ! empty ( $anylink_rules['rules'] ) )
                    echo implode( "\n", $anylink_rules['rules'] ); 
?></textarea>
            <p>
                <ul>
                    <li><?php _e( "any link contains domain in this whitelist won't be covered to short URL", "anylink" ) ?></li>
                    <li><?php _e( "please make sure one domain or URL each row", "anylink" ) ?></li>
                    <li><?php _e( "No 'http:' or 'www' needed", "anylink" ) ?></li>
                    <li><?php _e( "too many domains or urls are not recommended", "anylink" ) ?></li>
                </ul>
            </p>
            <p class="submit" style="clear: both;">
				<input type="submit" name="Submit"  class="button-primary" value="<?php _e( "Update Rules", "anylink" ); ?>" />
				<input type="hidden" name="anylink-rules-submit" value="Y" />
			</p>
        </form>
   <?php
        break;
        case 'support' :
        echo '<p class="form-table">';
        $support_sub  = __( 'Thanks for your chosing Anylink Wordpress plugin. Anylink is totally free now and in future. ', 'anylink' );
        $support_sub .= __( 'To help Anylink keeping maintained, I need your support. ', 'anylink' );
        $support_sub .= __( 'You can donate to me by two ways below. ', 'anylink' );
        $support_sub .= __( 'Also, you can recommend Anylink to other wordpress users.', 'anylink' );
        $support_sub .= __( 'Of course, you can leave a link point to my blog http://dudo.org. ', 'anylink' );
        $support_sub .= __( 'Anyway, thanks for all your support!', 'anylink' );
        echo $support_sub;
        echo "</p>";
   ?>
        <table>
            <tr>
                <td>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="hosted_button_id" value="VJZSYDA3VLCHJ">
                        <table>
                        <tr><td><input type="hidden" name="on0" value="Donate">Donate</td></tr><tr><td><select name="os0">
                        	<option value="Smile Donate">Smile Donate $ 3.33 USD</option>
                        	<option value="8-teeth Donate">8-teeth Donate $ 6.66 USD</option>
                        	<option value="Laugh Donate">Laugh Donate $ 9.99 USD</option>
                        </select> </td></tr>
                        </table>
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="image" src="<?php echo plugins_url( '/images/donate_paypal.gif', __FILE__ ); ?>" border="0" name="submit" alt="PayPal——最安全便捷的在线支付方式！">
                        <img alt="" border="0" src="https://www.paypalobjects.com/zh_XC/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </td>
                <td>
                    <img src="<?php echo plugins_url( '/images/donate_alipay.png', __FILE__ ); ?>" width="140" alt="" border="0" />
                </td>
                <td>
                    <img src="<?php echo plugins_url( '/images/donate_wechat.gif', __FILE__ ); ?>" width="140" alt="" border="0" />
                </td>
            </tr>
            <tr>
                <td><?php _e( 'Donate via Paypal', 'anylink' ); ?></td>
                <td><?php _e( 'Donate via Alipay by scanning QR code ', 'anylink'); ?></td>
                <td><?php _e( 'Donate via Wechat by scanning QR code ', 'anylink'); ?></td>
            </tr>
        </table>
        <h3>
            <?php
                _e( "Blog: <a href='http://dudo.org/' target='_blank'>http://dudo.org</a><br /><br />", "antlink" );
                _e( "QQ discuss group: 325735994", "anylink" );
            ?>
        </h3>
   <?php
        break;            
        case 'operation' :
    ?>
		<h3><?php _e( 'Establish Index', 'anylink' ); ?></h3>
	<form action="<?php echo admin_url( 'options-general.php?page=anyLinkSetting&tab=' . $tab ); ?>" method="post">
	<div id="anylink_index">
		<span class="plain"><?php _e( 'For the first time after you running anylink, you need indexing ALL posts. It\'ll let you establish index for the posts already in your Wordpress. For the newly publish or update post, index is done automatically. And you needn\'t do anything.', 'anylink' ); ?></span>
		<div id="anylink_bar">
			<div id="anylink_proceeding"> </div>
		</div>
		<input name="action" value="anylink_scan" type="hidden" />
        <input name="tab" value="operation" type="hidden" />
        <?php submit_button( __( 'Establish Index', 'anylink' ), 'secondary' ) ;?>
	</div>
	</form>
	<form action="<?php echo admin_url( 'options-general.php?page=anyLinkSetting&tab=' . $tab ); ?>" method="post">
		<span class="plain"><?php _e( 'For the first time running, you need scan all the exist comments manually.', "anylink" ) ?></b></span>
		<div id="slug_bar">
			<div id="anylink_comment_proceeding"> </div>
		</div>
		<input name="action" value="anylink_comment_scan" type="hidden" />
        <input name="tab" value="operation" type="hidden" />
		<?php submit_button( __( 'Regenerate comment slugs', 'anylink' ), 'secondary' ); ?>
	</form>
	<form action="<?php echo admin_url( 'options-general.php?page=anyLinkSetting&tab=' . $tab ); ?>" method="post">
		<span class="plain"><?php _e( 'Allows you to generate slugs manually. Keep in mind that please do not regenerate slugs unless you changed slug settings. Search engines may think that you have modified your articles.', 'anylink' ); ?><br /><b><?php _e( 'Note: It won\'t work unless slug settings are changed', 'anylink' ); ?></b></span>
		<div id="slug_bar">
			<div id="anylink_slug_proceeding"> </div>
		</div>
		<input name="action" value="anylink_regnerate" type="hidden" />
        <input name="tab" value="operation" type="hidden" />
		<?php submit_button( __( 'Regenerate slugs', 'anylink' ), 'secondary' ); ?>
	</form>
    <?php
        break;
        
     } ?>
</div>
<?php
if( isset( $_POST['action'] ) && $_POST['action'] == 'anylink_comment_scan' ) {
    flush();
    set_time_limit( 0 );
   	require_once( ANYLNK_PATH . "/classes/al_covert.php" );
	$objAllPost = new al_covert();
    $comment_IDs = $objAllPost -> get_all_comments();
    $j = count( $comment_IDs );
    $k = 0;
    foreach( $comment_IDs as $comment_ID ) {
        $objAllPost -> covertURLs( $comment_ID, true );
        $k += 1;
 ?>
 <script type="text/javascript">setDivStyle( "anylink_comment_proceeding", <?php echo round( $k / $j, 4 ); ?> ); </script> 
 <?php
    }
}
?>
<?php
if( isset( $_POST['action'] ) && $_POST['action'] == 'anylink_scan' ) {
	flush();
	set_time_limit( 0 );
	require_once( ANYLNK_PATH . "/classes/al_covert.php" );
	$objAllPost = new al_covert();
	$arrPostID = array();
	$arrPostID = $objAllPost -> arrGetPostIDs();
	$j = count( $arrPostID );
	$k = 0;
	foreach( $arrPostID as $ID ) {
		$objAllPost -> covertURLs( $ID );
		$k = $k + 1;
?>
<script type="text/javascript">setDivStyle( "anylink_proceeding", <?php echo round( $k / $j, 4 ); ?> ); </script> 
<?php
	flush();
	}
}
if( isset( $_POST['action'] ) && $_POST['action'] == 'anylink_regnerate' ) {
	$alOption = get_option( 'anylink_options' );
	if( $alOption['slugNum'] != $alOption['oldSlugNum'] || $alOption['slugChar'] != $alOption['oldSlugChar'] ) { 
		flush();
		set_time_limit( 0 );
		require_once( ANYLNK_PATH . "/classes/al_covert.php" );
		$objAllSlug = new al_covert();
		$arrSlugID = $objAllSlug -> getAllSlugID();
		$all = count( $arrSlugID );
		if( $all == 0 )
			$all = 1;
		$p = 0;
		$alOption['oldSlugNum'] = $alOption['slugNum'];
		$alOption['oldSlugChar'] = $alOption['slugChar'];
		update_option( 'anylink_options', $alOption );
		foreach( $arrSlugID as $slugID ) {
			$objAllSlug -> regenerateSlugByID( $slugID );
			$p = $p +1;
	?>
	<script type="text/javascript">setDivStyle( "anylink_slug_proceeding", <?php echo round( $p / $all, 4 ); ?> ); </script> 
	<?php
		flush();
		}
	}
}
    function alAdminTab( $current = 'general' ){
        $tabs = array( 'general' => __( 'General', 'anylink' ), 'rules' => __( 'Whitelist', 'anylink' ), 'operation' => __( 'Operation', 'anylink' ), 'support' => __( 'Support', 'anylink' ) );
        $links =array();
        echo '<div id="icon-themes" class="icon32"><br></div>';
        echo '<h2 class="nav-tab-wrapper">';
        foreach( $tabs as $tab => $name ){
            $class = ( $tab == $current ) ? 'nav-tab-active' : '';
            echo "<a class='nav-tab $class' href='?page=anyLinkSetting&tab=$tab'>$name</a>";            
        }
        echo '</h2>';        
    } 
?>