<script src="<?php bloginfo('template_directory'); ?>/js/posfixed.js"></script>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/fancybox/fancybox.css" />  
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/fancybox/fancybox.js"></script>  
  <script type="text/javascript">  
    $(document).ready(function() {  
        $(".fancybox").fancybox();  
    });  
</script> 
</section>

<footer class="footer">

<div class="footer-inner">
        <div class="copyright pull-left">          
          <p>Copyright <span class="s">©</span> 2014 - <?php echo date("Y"); ?>&nbsp;<a href="<?php site_url(); ?>" title="<?php bloginfo('name'); ?>"><?php bloginfo('name'); ?> <a/> 个人博客 - 前平安集团全栈工程师 <p/>
		  </div>
      
		
          <?php if( dopt('d_track_b') ) echo dopt('d_track'); ?>
      </div>

	<div class="dandelion">
    <span class="smalldan"></span>
    <span class="bigdan"></span>
</div>
 
<style type="text/css">
@media screen and (max-width:600px){
.dandelion{display: none !important;}
}
    .dandelion .smalldan {
width: 36px;
height: 60px;
left: 21px;
background-position: 0 -90px;
border: 0px solid red;
}
.dandelion span {
-webkit-animation: ball-x 3s linear 2s infinite;
  -moz-animation: ball-x 3s linear 2s infinite;
  animation: ball-x 3s linear 2s infinite;
-webkit-transform-origin: bottom center;
  -moz-transform-origin: bottom center;
  transform-origin: bottom center;
}
.dandelion span {
display: block;
position: fixed;
z-index:9999999999;
bottom: 0px;
background-image: url(https://tmy123.com/pgy.png);
background-repeat: no-repeat;
_background: none;
}
.dandelion .bigdan {
width: 64px;
height: 115px;
left: 47px;
background-position: -86px -36px;
border: 0px solid red;
}
@keyframes ball-x {
    0% { transform:rotate(0deg);}
   20% { transform:rotate(5deg); }
   40% { transform:rotate(0deg);}
   60% { transform:rotate(-5deg);}
   80% { transform:rotate(0deg);}
   100% { transform:rotate(0deg);}
}
@-webkit-keyframes ball-x {
    0% { -webkit-transform:rotate(0deg);}
   20% { -webkit-transform:rotate(5deg); }
   40% { -webkit-transform:rotate(0deg);}
   60% { -webkit-transform:rotate(-5deg);}
   80% { -webkit-transform:rotate(0deg);}
   100% { -webkit-transform:rotate(0deg);}
}
@-moz-keyframes ball-x {
    0% { -moz-transform:rotate(0deg);}
   20% { -moz-transform:rotate(5deg); }
   40% { -moz-transform:rotate(0deg);}
   60% { -moz-transform:rotate(-5deg);}
   80% { -moz-transform:rotate(0deg);}
   100% { -moz-transform:rotate(0deg);}
}
</style>
</footer>

<?php 
wp_footer(); 
global $dHasShare; 
if($dHasShare == true){ 
	echo'<script>with(document)0[(getElementsByTagName("head")[0]||body).appendChild(createElement("script")).src="http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion="+~(-new Date()/36e5)];</script>';
}  
if( dopt('d_footcode_b') ) echo dopt('d_footcode'); 
?>

</body>
</html>