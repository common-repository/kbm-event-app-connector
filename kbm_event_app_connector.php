<?php
/*
Plugin Name: KBM Event App Connector
Description: A connector which allows quick access to event's and performances.
Author: Keen.com.mt
Version: 1.0.4
Author URI: http://www.keen.com.mt
*/

class KBM_Event_App_Connector {

	public static function init() {
		
		add_shortcode( 'kbm_performance', 	array(__CLASS__ , 'add_performance_shortcode') );
		add_shortcode( 'kbm_event', 		array(__CLASS__ , 'add_event_shortcode') );
	
	}
	
	public static function add_performance_shortcode($attrs) {
	
		extract( shortcode_atts( array(
			'id' => '',
			'lang' => 'en',
			'account' => ''
		), $attrs ) );
		
		if (empty($id)) return;
		
$template = <<<TEMPLATE
<script src="//kbm.keen.com.mt/w/theatre/performance/$id/$account/$lang" type="text/javascript"></script>
	<script type="text/javascript">
		/*
			kbm_performance (object) will be returned and will consist of performance with start and end date and booking url.
		*/
		document.writeln([
			'<div>',
				'<a target="_blank" href="'+kbm_performance.url+'">',
					'<i>'+kbm_performance.start_date+'</i>&nbsp;&mdash;&nbsp;<span>Buy&nbsp;Now&nbsp;&raquo;</span>',
				'</a>',
			'</div>'
		].join(''));
	</script>		
TEMPLATE;

		return $template;
	
	}
	
	public static function add_event_shortcode($attrs) {
	
		extract( shortcode_atts( array(
			'id' => '',
			'lang' => 'en',
			'account' => ''
		), $attrs ) );
		
		if (empty($id)) return;
		
$template = <<<TEMPLATE
<script src="//kbm.keen.com.mt/w/theatre/event/$id/$account/$lang" type="text/javascript"></script>
<script type="text/javascript">
	/*
		kbm_performances (object) will be returned and will consist of event title, description 
		and list of performances with start and end date and booking url.
	*/
	document.writeln('<h3>'+kbm_performances.title+'</h3>');
	document.writeln('<p>'+kbm_performances.description+'</p>');
	
	var has_performances = false;
	
	for (var performance in kbm_performances.performances) {
	
		var the_performance = kbm_performances.performances[performance];
		
		has_performances = true;
		
		document.writeln([
			'<div>',
				'<a target="_blank" href="'+the_performance.url+'">',
					'<i>'+the_performance.start_date+'</i>&nbsp;&mdash;&nbsp;<span>Buy&nbsp;Now&nbsp;&raquo;</span>',
				'</a>',
			'</div>'
		].join(''));
	
	}
	
	if (has_performances === false) 
		document.writeln('Not Available');
</script>
TEMPLATE;

		return $template;
	
	
	}

}

KBM_Event_App_Connector::init();
?>
