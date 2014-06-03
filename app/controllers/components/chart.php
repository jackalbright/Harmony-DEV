<?
/*
	For handling uploading of images from a web page, saving to disk, scaling to create thumbnails, etc...

*/

include_once(dirname(__FILE__)."/../../../includes/php-ofc-library/open-flash-chart.php");

class ChartComponent extends Object
{
	var $name = 'Chart';
	var $components = array();
	var $config = array();
	var $controller = null;
	var $force_type = null;
	var $allowed = null;
	var $x_axis_steps = 7; # Default.

	function startup(&$controller)
	{
		$this->controller = $controller;
	}

	function create($data, $labels)
	{
		$this->data = $data;
		$this->labels = $labels;
	}
	function set_x_axis_steps($steps)
	{
		$this->x_axis_steps = $steps;
	}

	function title($title)
	{
		$this->title = $title;
	}

	function render($type = 'line')
	{
		Configure::write("debug", 0);
		header('Content-Type: text/plain');
?>
{ 
	"title": { "text": "<?= !empty($this->title) ? $this->title : "" ?>" },
	"elements": [ 
		{ 
		"type": "<?= $type ?>", 
		"values": [ 
			<? for($i = 0; $i < count($this->data); $i++) { 
				$value = $this->data[$i];
				$label = $this->labels[$i];
				echo $i > 0 ? ",\n" : "\n";
			?>
			{ "type": "<?= $type ?>", "value": <?= $value ?>, "colour": "#D02020", "tip": "<?= $label ?> 
#val#" }<? } ?>

		], 
		"width": 2, 
		"colour": "#DFC329" 
		}
	], 
	"x_axis": { 
		"steps": <?= $this->x_axis_steps; ?>, 
		"labels": { 
			"colour": "#ff0000", "rotate": 45, 
			"labels": [ <? for($i = 0; $i < count($this->labels); $i++) { echo ($i>0?", ":""). '"'.$this->labels[$i].'"'; } ?> ], "steps": 7 } 
		}, 
	"y_axis": { "min": 0, "max": <?= max($this->data)*1.2 ?>, "steps": <?= intval(max($this->data)*1.2 / 15) ?> } }
		<?
		exit();
	}

	function render_dual_bar()
	{
		header('Content-Type: text/plain');
?>{
  "title":{
    "text":  "<?= !empty($this->title) ? $this->title : "" ?>",
    "style": "{font-size: 20px; color:#0000ff; font-family: Verdana; text-align: center;}"
  },
 
  "y_legend":{
    "text": "Open Flash Chart",
    "style": "{color: #736AFF; font-size: 12px;}"
  },
 
  "elements":[
    {
      "type":      "bar",
      "alpha":     0.5,
      "colour":    "#9933CC",
      "text":      "Page views",
      "font-size": 10,
      "values" :   [9,6,7,9,5,7,6,9,7]
    },
    {
      "type":      "bar",
      "alpha":     0.5,
      "colour":    "#CC9933",
      "text":      "Page views 2",
      "font-size": 10,
      "values" :   [6,7,9,5,7,6,9,7,3]
    }
  ],
 
  "x_axis":{
    "stroke":1,
    "tick_height":10,
    "colour":"#d000d0",
    "grid_colour":"#00ff00",
    "labels": {
        "labels": ["January","February","March","April","May","June","July","August","Spetember"]
    }
   },
 
  "y_axis":{
    "stroke":      4,
    "tick_length": 3,
    "colour":      "#d000d0",
    "grid_colour": "#00ff00",
    "offset":      0,
    "max":         20
  }
}
		<?
		exit();
	}
}

?>
