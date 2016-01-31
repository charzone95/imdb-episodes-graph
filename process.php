<?php

error_reporting(null);

$imdbId = @$_GET['id'];

$html = file_get_contents("http://www.imdb.com/title/{$imdbId}/epdate");

//get title
preg_match_all('/\<title\>(.*)\<\/title\>/s', $html, $temp);
$title = $temp[1][0];


//get table container
preg_match_all('/\<div id="tn15content"\>(.*)\<br style="clear:both;" \/\>/s', $html, $temp);
$tableContainer = $temp[1][0];

//get each row
$temp = explode("<tr>", $tableContainer);
unset($temp[0]);
for ($i=0;$i<count($temp);$i++) {
	$temp[$i] = @reset(explode("</tr>", $temp[$i]));
}
$rows = $temp;
//var_dump($rows);

//get each element

/*
 * Structure :
 * - 'episode' => episode number
 * - 'link' => episode link
 * - 'title' => episode name
 * - 'rating' => the rating
 * - 'users' => no. of users
 */

$result = [];

foreach ($rows as $key=>$val) {
	$arr = [];
	
	$arr['episode'] = reset(explode("&#160;", explode('<td align="right" bgcolor="#eeeeee">', $val)[1]));
	$arr['link'] = explode('">', explode('<a href="', $val)[1])[0];
	$arr['title'] = explode('</a>', explode('">', explode('<a href="', $val)[1])[1])[0];
	$arr['rating'] = (float)explode('</td>', explode('<td align="right">', $val)[1])[0];
	$arr['users'] = (int)explode('</td>', explode('<td align="right">', $val)[2])[0];
	
	//if no rating, skip (not released yet)
	if ($arr['users']) {
		$result[] = $arr;
	}
}


//generate variable versions of result (maybe will use this later)
$episodes = [];
$links = [];
$titles = [];
$ratings = [];
$users = [];
$series = [];
foreach ($result as $val) {
	$episodes[] = $val['episode'];
	$links[] = $val['link'];
	$titles[] = $val['title'];
	$ratings[] = $val['rating'];
	$users[] = $val['users'];
	
	$temp = [];
	$temp['y'] = $val['rating'];
	$temp['link'] = $val['link'];
	$temp['title'] = $val['title'];
	$temp['episode'] = $val['episode'];
	$temp['users'] = $val['users'];
	$series[] = $temp;
}


?>
<script src="https://code.highcharts.com/highcharts.js"></script>

<h2 style="text-align:center">
	<?php echo $title?><br/>
	<small>Source: <a href="http://www.imdb.com/title/<?php echo $imdbId?>/" target="_blank">IMDB.com</a></small>
</h2>

<div id="result"></div>

<script>
$(function () {
    $('#result').highcharts({
        xAxis: {
            categories: <?php echo json_encode($episodes)?>
        },
        yAxis: {
            title: {
                text: 'Rating'
            },
            
        },
       	colors: ['#2196F3'],
        series: [
			{
	            name: 'Rating',
	            data: <?php echo json_encode($series)?>
        	}
        ],
        tooltip: {
            formatter: function() {
                var eps = this.point.episode.split('.');
            	return '<b>'+ this.point.title+'</b><br/>'+
            		'(Season '+ eps[0] +' Episode '+ eps[1] +')<br/>'+
					'Rating: <b>'+this.y+'</b>/10 ('+this.point.users+' users)';
            }
       	},
       	legend: {
			enabled: false
       	},
        plotOptions: {
            series: {
                cursor: 'pointer',
                point: {
                    events: {
                        click: function (e) {
                           window.open('http://www.imdb.com' + this.link);
                        }
                    }
                },
                marker: {
                    lineWidth: 1
                }
            }
        },
    });
});

</script>