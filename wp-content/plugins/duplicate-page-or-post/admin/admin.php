<?php

class wpda_duplicate_post_admin_panel{
	private $parametrs;
	function __construct(){
		$this->initial_standart_parametrs();
		$this->admin_filters();		
	}

	/*###################### Admin filters function ##################*/	
		
	private function admin_filters(){
		//hook for admin menu
		add_action( 'admin_menu', array($this,'create_admin_menu') );
		// hook for saving options in databese
		add_action( 'wp_ajax_wpdevart_duplicate_post_parametrs_save_in_db', array($this,'save_in_db'));
		// filters for ading external link on page and post list
		add_filter('post_row_actions', array($this,'duplicate_post_page_link'),10,2);
		add_filter('page_row_actions', array($this,'duplicate_post_page_link'),10,2);
		add_action('admin_action_wpdevart_duplicate_post_page',array($this,"duplicate_post_or_page"));
	}
	public function duplicate_post_page_link($actions, $post){
		if ( $post->post_type == "post" || $post->post_type == "page" ) {
			$url = admin_url( 'admin.php' );	 
			if ( current_user_can( 'edit_post', $post->ID ) ) {	 
				// Include a nonce in this link
				$copy_link = wp_nonce_url( add_query_arg( array( 'action' => 'wpdevart_duplicate_post_page','post_id'=>$post->ID ), $url ), 'wpdevart_clone_post_page_nonce' );
		 
				// Add the new Copy quick link.
				$actions = array_merge( $actions, array(
									'copy' => sprintf( '<a href="%1$s">%2$s</a>',
										esc_url( $copy_link ), 
										'Duplicate'
									) 
								 ) 
				);
			}
		}	 
		return $actions;
	}
	//conect admin menu
	public function create_admin_menu(){
		global $submenu;
		/* conect admin pages to wordpress core*/
		$main_page=add_menu_page( "Duplicate Post", "Duplicate Post", 'manage_options', "wpda_duplicate_post_menu", array($this, 'options_page'));
		add_submenu_page( "wpda_duplicate_post_menu", "Duplicate Post", "Duplicate Post", 'manage_options',"wpda_duplicate_post_menu",array($this, 'options_page'));		
		add_submenu_page( "wpda_duplicate_post_menu", "Featured Plugins", "Featured Plugins", 'manage_options',"wpda_duplicate_post_feature_plugin",array($this, 'featured_plugins'));
		/*for including page styles and scripts*/
		add_action('admin_print_styles-' .$main_page, array($this,'create_option_page_style_js'));	
		
		if(isset($submenu['wpda_duplicate_post_menu']))
			add_submenu_page( 'wpda_duplicate_post_menu', "Support or Any Ideas?", "<span style='color:#00ff66' >Support or Any Ideas?</span>", 'manage_options',"wpdevart_comingsoon_any_ideas",array($this, 'any_ideas'),155);
		if(isset($submenu['wpda_duplicate_post_menu']))
			$submenu['wpda_duplicate_post_menu'][2][2]=wpdevart_duplicate_post_support_url;	
	}
	
	    /*###################### Standard parameters function ##################*/	
		
	private function initial_standart_parametrs(){
		$this->parametrs["title_prefix"]="";
		$this->parametrs["copy_title"]="1";
		$this->parametrs["title_sufix"]="";
		$this->parametrs["copy_content"]="1";
		$this->parametrs["copy_excerpt"]="1";
		$this->parametrs["copy_date"]="1";
		$this->parametrs["copy_status"]="1";
		$this->parametrs["copy_featured_image"]="1";
		$this->parametrs["copy_template"]="1";
		$this->parametrs["copy_format"]="1";
		$this->parametrs["copy_author"]="1";
		$this->parametrs["copy_password"]="1";
		$this->parametrs["copy_attachments"]="1";
		$this->parametrs["copy_comments"]="1";
		$this->parametrs["copy_categories"]="1";
		$this->parametrs["copy_tags"]="1";
		if(is_array($params=get_option("wpdevart_duplicate_post_admin_parametrs","no_params"))){			
			foreach($this->parametrs as $key => $value){
				if(isset($params[$key])){
					$this->parametrs[$key]=$params[$key];
				}
			}
		}
	}
	
    /*###################### Database function ##################*/		
	
	public function save_in_db(){
		if(check_ajax_referer("wpdevart_duplicate_post_parametrs_save_in_db","wpdevart_duplicate_post_save_paramas_nonce",false)){
			wp_die('Security error.');
		}
		
		foreach($this->parametrs as $key => $value){
			if(isset($_POST[$key])){
				$this->parametrs[$key]=sanitize_text_field($_POST[$key]);
			}
		}
		update_option("wpdevart_duplicate_post_admin_parametrs",$this->parametrs);
		wp_die('1');
		
	}
	/* timer page style and js*/	
	public function create_option_page_style_js(){		
		//scripts
		wp_enqueue_script('jquery');
		wp_enqueue_style('wpdevart_duplicate_post_admin_menu_css',wpda_duplicate_post_plugin_url.'admin/css/duplicate_post_menu.css');	
		wp_enqueue_script('wpdevart_duplicate_post_admin_menu_js',wpda_duplicate_post_plugin_url.'admin/js/duplicate_post_menu.js');
		wp_localize_script( 'wpdevart_duplicate_post_admin_menu_js', 'wpdevart_js_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ), 'we_value' => 1234 ) );		
	}
	
	public function options_page(){
		?>
		<h1>Duplicate Page or Post</h1><br>
		<div class="main_parametrs_group_div">
			<div class="head_panel_div" title="Click to toggle">
            	<span class="title_parametrs_image">
					
				</span>
				<span class="title_parametrs_group">Duplicate Page or Post Settings</span>
				<span class="enabled_or_disabled_parametr"></span>        
			</div>
			<div class="inside_information_div" style="display: block;">
				<table id="wpdevart_parametrs_table" class="wp-list-table widefat fixed posts section_parametrs_table"> 
					<tbody>				
						<tr>
							<td>Title prefix (prefix is the custom text before the title)</td>
							<td>
								<input type="text" id="title_prefix" value="<?php echo $this->parametrs["title_prefix"]; ?>" >
							</td>
						</tr>
						<tr>
							<td>Copy title from duplicated page/post?</td>
							<td>
								<select id="copy_title">
									<option <?php selected($this->parametrs["copy_title"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_title"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Title sufix (sufix is the custom text after the title)</td>
							<td>
								<input type="text" id="title_sufix" value="<?php echo $this->parametrs["title_sufix"]; ?>" >
							</td>
						</tr>
						<tr>
							<td>Copy Content from duplicated page/post?</td>
							<td>
								<select id="copy_content">
									<option <?php selected($this->parametrs["copy_content"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_content"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Excerpt from duplicated page/post?</td>
							<td>
								<select id="copy_excerpt">
									<option <?php selected($this->parametrs["copy_excerpt"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_excerpt"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						
						<tr>
							<td>Copy Date from duplicated page/post?</td>
							<td>
								<select id="copy_date">
									<option <?php selected($this->parametrs["copy_date"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_date"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Status from duplicated page/post?</td>
							<td>
								<select id="copy_status">
									<option <?php selected($this->parametrs["copy_status"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_status"],"0"); ?> value="0">Copy and set as draft</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Featured Image from duplicated page/post?</td>
							<td>
								<select id="copy_featured_image">
									<option <?php selected($this->parametrs["copy_featured_image"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_featured_image"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Template from duplicated page/post?</td>
							<td>
								<select id="copy_template">
									<option <?php selected($this->parametrs["copy_template"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_template"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Format from duplicated page/post?</td>
							<td>
								<select id="copy_format">
									<option <?php selected($this->parametrs["copy_format"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_format"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Author(page/post author) from duplicated page/post?</td>
							<td>
								<select id="copy_author">
									<option <?php selected($this->parametrs["copy_author"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_author"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Password(page/post password) from duplicated page/post?</td>
							<td>
								<select id="copy_password">
									<option <?php selected($this->parametrs["copy_password"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_password"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Comments from duplicated page/post?</td>
							<td>
								<select id="copy_comments">
									<option <?php selected($this->parametrs["copy_comments"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_comments"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Categories from duplicated page/post?</td>
							<td>
								<select id="copy_categories">
									<option <?php selected($this->parametrs["copy_categories"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_categories"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Copy Tags from duplicated page/post?</td>
							<td>
								<select id="copy_tags">
									<option <?php selected($this->parametrs["copy_tags"],"1"); ?> value="1">Yes</option>
									<option <?php selected($this->parametrs["copy_tags"],"0"); ?> value="0">No</option>
								</select>
							</td>
						</tr>
						<tr style="display:none">
							<td><input type="hidden" id="wpdevart_duplicate_post_save_paramas_nonce" value="<?php echo wp_create_nonce( "wpdevart_duplicate_post_save_paramas_nonce" ); ?>"></td>
						</tr>
					</tbody>
					<tfoot>
						<tr>
							<th colspan="2" width="100%"><button data-clickabel="yes" type="button" id="wpdevart_save_in_databese" class="save_section_parametrs button button-primary"><span class="save_button_span">Save Settings</span> <span class="saving_in_progress"> </span><span class="sucsses_save"> </span><span class="error_in_saving"> </span></button><span class="error_massage"> </span></th>
						</tr>
					</tfoot>       
				</table>
			</div>     
		</div>
		<?php
	}
	/*############################### Featured plugins function ########################################*/
	
	public function featured_plugins(){
		$plugins_array=array(
			'gallery_album'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/gallery-album-icon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-gallery-plugin',
						'title'			=>	'WordPress Gallery plugin',
						'description'	=>	'Gallery plugin is an useful tool that will help you to create Galleries and Albums. Try our nice Gallery views and awesome animations.'
						),		
			'coming_soon'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/coming_soon.jpg',
						'site_url'		=>	'http://wpdevart.com/wordpress-coming-soon-plugin/',
						'title'			=>	'Coming soon and Maintenance mode',
						'description'	=>	'Coming soon and Maintenance mode plugin is an awesome tool to show your visitors that you are working on your website to make it better.'
						),
			'Contact forms'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/contact_forms.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-contact-form-plugin/',
						'title'			=>	'Contact Form Builder',
						'description'	=>	'Contact Form Builder plugin is an handy tool for creating different types of contact forms on your WordPress websites.'
						),	
			'Booking Calendar'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/Booking_calendar_featured.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-booking-calendar-plugin/',
						'title'			=>	'WordPress Booking Calendar',
						'description'	=>	'WordPress Booking Calendar plugin is an awesome tool to create a booking system for your website. Create booking calendars in a few minutes.'
						),
			'Pricing Table'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/Pricing-table.png',
						'site_url'		=>	'https://wpdevart.com/wordpress-pricing-table-plugin/',
						'title'			=>	'WordPress Pricing Table',
						'description'	=>	'WordPress Pricing Table plugin is a nice tool for creating beautiful pricing tables. Use WpDevArt pricing table themes and create tables just in a few minutes.'
						),							
			'youtube'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/youtube.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-youtube-embed-plugin',
						'title'			=>	'WordPress YouTube Embed',
						'description'	=>	'YouTube Embed plugin is an convenient tool for adding videos to your website. Use YouTube Embed plugin for adding YouTube videos in posts/pages, widgets.'
						),
            'facebook-comments'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/facebook-comments-icon.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-facebook-comments-plugin/',
						'title'			=>	'Wpdevart Social comments',
						'description'	=>	'WordPress Facebook comments plugin will help you to display Facebook Comments on your website. You can use Facebook Comments on your pages/posts.'
						),						
			'countdown'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/countdown.jpg',
						'site_url'		=>	'http://wpdevart.com/wordpress-countdown-plugin/',
						'title'			=>	'WordPress Countdown plugin',
						'description'	=>	'WordPress Countdown plugin is an nice tool for creating countdown timers for your website posts/pages and widgets.'
						),
			'lightbox'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/lightbox.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-lightbox-plugin',
						'title'			=>	'WordPress Lightbox plugin',
						'description'	=>	'WordPress Lightbox Popup is an high customizable and responsive plugin for displaying images and videos in popup.'
						),
			'facebook'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/facebook.jpg',
						'site_url'		=>	'http://wpdevart.com/wordpress-facebook-like-box-plugin',
						'title'			=>	'Social Like Box',
						'description'	=>	'Facebook like box plugin will help you to display Facebook like box on your wesite, just add Facebook Like box widget to sidebar or insert it into posts/pages and use it.'
						),
			'poll'=>array(
						'image_url'		=>	wpda_duplicate_post_plugin_url.'admin/images/featured_plugins/poll.png',
						'site_url'		=>	'http://wpdevart.com/wordpress-polls-plugin',
						'title'			=>	'WordPress Polls system',
						'description'	=>	'WordPress Polls system is an handy tool for creating polls and survey forms for your visitors. You can use our polls on widgets, posts and pages.'
						),
						
			
		);
		?>
        <style>
         .featured_plugin_main{
			background-color: #ffffff;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			float: left;
			margin-right: 30px;
			margin-bottom: 30px;
			width: calc((100% - 90px)/3);
			border-radius: 15px;
			box-shadow: 1px 1px 7px rgba(0,0,0,0.04);
			padding: 20px 25px;
			text-align: center;
			-webkit-transition:-webkit-transform 0.3s;
			-moz-transition:-moz-transform 0.3s;
			transition:transform 0.3s;   
			-webkit-transform: translateY(0);
			-moz-transform: translateY0);
			transform: translateY(0);
			min-height: 344px;
		 }
		.featured_plugin_main:hover{
			-webkit-transform: translateY(-2px);
			-moz-transform: translateY(-2px);
			transform: translateY(-2px);
		 }
		.featured_plugin_image{
			max-width: 128px;
			margin: 0 auto;
		}
		.blue_button{
			display: inline-block;
			font-size: 15px;
			text-decoration: none;
			border-radius: 5px;
			color: #ffffff;
			font-weight: 400;
			opacity: 1;
			-webkit-transition: opacity 0.3s;
			-moz-transition: opacity 0.3s;
			transition: opacity 0.3s;
			background-image: linear-gradient(141deg, #32d6db, #00a0d2);
			padding: 10px 22px;
			text-transform: uppercase;
		}
		.blue_button:hover,
		.blue_button:focus {
			color:#ffffff;
			box-shadow: none;
			outline: none;
		}
		.featured_plugin_image img{
			max-width: 100%;
		}
		.featured_plugin_image a{
		  display: inline-block;
		}
		.featured_plugin_information{	

		}
		.featured_plugin_title{
			color: #0073aa;
			font-size: 18px;
			display: inline-block;
		}
		.featured_plugin_title a{
			text-decoration:none;
			font-size: 19px;
			line-height: 22px;
			color: #00a0d2;
					
		}
		.featured_plugin_title h4{
			margin: 0px;
			margin-top: 20px;		
			min-height: 44px;	
		}
		.featured_plugin_description{
			font-size: 14px;
				min-height: 63px;
		}
		@media screen and (max-width: 1460px){
			.featured_plugin_main {
				margin-right: 20px;
				margin-bottom: 20px;
				width: calc((100% - 60px)/3);
				padding: 20px 10px;
			}
			.featured_plugin_description {
				font-size: 13px;
				min-height: 63px;
			}
		}
		@media screen and (max-width: 1279px){
			.featured_plugin_main {
				width: calc((100% - 60px)/2);
				padding: 20px 20px;
				min-height: 363px;
			}	
		}
		@media screen and (max-width: 768px){
			.featured_plugin_main {
				width: calc(100% - 30px);
				padding: 20px 20px;
				min-height: auto;
				margin: 0 auto 20px;
				float: none;
			}	
			.featured_plugin_title h4{
				min-height: auto;
			}	
			.featured_plugin_description{
				min-height: auto;
					font-size: 14px;
			}	
		}

        </style>
      
		<h1>Featured Plugins</h1>
		<?php foreach($plugins_array as $key=>$plugin) { ?>
		<div class="featured_plugin_main">
			<div class="featured_plugin_image"><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><img src="<?php echo $plugin['image_url'] ?>"></a></div>
			<div class="featured_plugin_information">
				<div class="featured_plugin_title"><h4><a target="_blank" href="<?php echo $plugin['site_url'] ?>"><?php echo $plugin['title'] ?></a></h4></div>
				<p class="featured_plugin_description"><?php echo $plugin['description'] ?></p>
				<a target="_blank" href="<?php echo $plugin['site_url'] ?>" class="blue_button">Check The Plugin</a>
			</div>
			<div style="clear:both"></div>                
		</div>
		<?php } 
	
	}

	public function duplicate_post_or_page(){
		//current user have a preveligies to edit post or page
		if(!current_user_can( 'edit_posts' )){
			wp_die("you don't have a permission");
		}
		// check user come from right place
		check_admin_referer('wpdevart_clone_post_page_nonce');	
		// if we don't have post id we can't continue copy post
		if (!(isset($_GET['post_id']) && $_GET['post_id']!='')) {
			wp_die("not detected post");
		}
		$post_id=sanitize_text_field($_GET['post_id']);
		$original_post=get_post($post_id);
		$pos_arr = array(		
			'post_title' => $this->get_copied_post_title($original_post),
			'post_type' => $original_post->post_type,
			'post_name' => $original_post->post_name,
			'post_content' => $this->get_post_content($original_post),
			'post_excerpt' =>$this->get_post_excerpt($original_post),
			'post_date' => $this->get_post_date($original_post),
			'post_status' => $this->get_post_status($original_post),
			'post_author' =>  $this->get_author($original_post),
			'post_password' => $this->get_password($original_post),			
			'comment_status' => $original_post->comment_status,
			'ping_status' => $original_post->ping_status,			
			'post_content_filtered' =>$original_post->post_content_filtered,				
			'post_mime_type' => $original_post->post_mime_type,
			'post_parent' =>$original_post->post_parent,
		);
		$post_id=wp_insert_post($pos_arr);
		if($post_id==0){
			wp_die("Error copy post");
		}
		$new_post=get_post($post_id);
		$this->duplicate_meta_dates($original_post,$new_post);
		$this->duplicate_post_format($original_post,$new_post);
		$this->duplicate_comments($original_post,$new_post);
		$this->duplicate_categories($original_post,$new_post);
		$this->duplicate_tags($original_post,$new_post);
		$this->redirect_url($original_post);

	}
	/******************************HELPER FUNCTIONS********************************/
	private function get_copied_post_title($post){
		
		$title=$this->parametrs["title_prefix"].(($this->parametrs["copy_title"]=="1")?$post->post_title:"").$this->parametrs["title_sufix"];
		if($title==""){
			return "Untitled";
		}
		return $title;
		
	}
	private function get_post_content($post){
		if($this->parametrs["copy_content"]=="1"){
			return $post->post_content;
		}
		return "";		
	}
	private function get_post_excerpt($post){
		if($this->parametrs["copy_excerpt"]=="1"){
			return $post->post_excerpt;
		}
		return "";		
	}
	private function get_post_date($post){
		if($this->parametrs["copy_date"]=="1"){
			return $post->post_date;
		}
		return "";		
	}
	
	private function get_author($post){
		$current_user=wp_get_current_user();
		if($this->parametrs["copy_author"]=="1"){
			return $post->post_author;
		}
		return $current_user->ID;		
	}
	private function get_password($post){
		$current_user=wp_get_current_user();
		if($this->parametrs["copy_password"]=="1"){
			return $post->post_password;
		}
		return "";		
	}
	private function get_post_status($post){
		$current_user=wp_get_current_user();
		if($this->parametrs["copy_status"]=="1"){
			return get_post_status($post->ID);
		}
		return "draft";		
	}
	private function duplicate_meta_dates($original_post,$new_post){
		$original_post_metas=get_post_meta($original_post->ID);
		foreach($original_post_metas as $original_key=>$original_post_meta){
			if($original_key=="_thumbnail_id" && $this->parametrs["copy_featured_image"]=="0"){
				continue;
			}
			if($original_key=="_wp_page_template" && $this->parametrs["copy_template"]=="0"){
				continue;
			}
			if(count($original_post_meta)>1){
				update_post_meta($new_post->ID,$original_key,$original_post_meta);
			}else{
				if(is_array($original_post_meta)){
					update_post_meta($new_post->ID,$original_key,$original_post_meta[0]);
				}else{
					update_post_meta($new_post->ID,$original_key,$original_post_meta);
				}				
			}
			
		}
	}
	private function duplicate_comments($original_post,$new_post){
		if(!$this->parametrs["copy_comments"]=="1"){
			return 1;
		}
		//get original post comments
		$comments = get_comments(array(
			'post_id' => $original_post->ID,
			'order' => 'ASC',
			'orderby' => 'comment_date_gmt'
		));
		// reserve all old ids in keys and value new id
		$old_id_to_new_id = array();
		foreach ($comments as $comment){
			$commentdata = array(
				'comment_post_ID' => $new_post->ID,
				'comment_author' => $comment->comment_author,
				'comment_author_email' => $comment->comment_author_email,
				'comment_author_url' => $comment->comment_author_url,
				'comment_content' => $comment->comment_content,
				'comment_type' => '', 
				'comment_parent' => isset($old_id_to_new_id[$comment->comment_parent])?$old_id_to_new_id[$comment->comment_parent]:0,
				'user_id' => $comment->user_id,
				'comment_author_IP' => $comment->comment_author_IP,
				'comment_agent' => $comment->comment_agent,
				'comment_karma' => $comment->comment_karma,
				'comment_approved' => $comment->comment_approved,
				'comment_date'		=> $comment->comment_date,
				'comment_date_gmt'	=> get_gmt_from_date($comment->comment_date),
			);
			$new_comment_id = wp_insert_comment($commentdata);
			$old_id_to_new_id[$comment->comment_ID] = $new_comment_id;
		}
	}
	
	    /*###################### Categories duplicate function ##################*/	
	
	private function duplicate_categories($original_post,$new_post){
		if(!$this->parametrs["copy_categories"]=="1"){
			return 1;
		}
		$original_categories=wp_get_post_categories( $original_post->ID);
		wp_set_post_categories($new_post->ID,$original_categories);
	}
	private function duplicate_tags($original_post,$new_post){
		if(!$this->parametrs["copy_tags"]=="1"){
			return 1;
		}
		$original_tags_terms=wp_get_post_tags( $original_post->ID);
		$original_tags=array();
		foreach($original_tags_terms as $original_tags_term){
			array_push($original_tags,$original_tags_term->name);
		}
		wp_set_post_tags($new_post->ID,$original_tags);
	}
	
	private function duplicate_post_format($original_post,$new_post){
		$original_post_format=get_post_format($original_post);
		if($this->parametrs["copy_format"]=="1" && $original_post_format){
			set_post_format($new_post,$original_post_format);
		}
		return 1;
	}
	
	private function redirect_url($post){
		switch($post->post_type){
			case "post":
				wp_redirect(admin_url( 'edit.php' ));
			break;
			case "page":
				wp_redirect(admin_url( 'edit.php?post_type=page' ));
			break;
		}		
	}
}
	?>