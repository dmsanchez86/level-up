<?php

//namespace GcalJson;

class GcalJson {

	function proofUrl($url) {

		$handle = curl_init($url);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($handle);
		$http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

		if($http_code == 404) {
			return false;
		} else {
			return true;
		}

	}

	function aasort($array, $key) {

		$sorter = array();
		$ret = array();
		reset($array);
		foreach ($array as $ii => $va) {
			$sorter[$ii]=$va[$key];
		}
		asort($sorter);
		foreach ($sorter as $ii => $va) {
			$ret[$ii]=$array[$ii];
		}
		$array = $ret;
		return $array;

	}

	function getJson($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
	}

	function parse($json) {

		if(!$json) {
			return false;
		}
		$json = json_decode($json);

		$events = array();

		$counter = 0;
		foreach ($json->feed->entry as $item) {

			$array_item = (array) $item;

			if(count($array_item['gd$when']) > 1) {

				for ($i = 1; $i <= count($array_item['gd$when'])-1; $i++) {

					//echo $item->title->$t;
					$title = (array) $item->title;
					$title = $title['$t'];

					$start = $array_item['gd$when'][$i-1]->startTime;
					$end  = $array_item['gd$when'][$i-1]->endTime;
					$where = @$array_item['gd$where'][0]->valueString;
					$status = (strpos($array_item['gd$eventStatus']->value,"canceled") > 0 ? "canceled" : "active");
					$content = (array) $item->content;
					$content = $content['$t'];
					$id = (array) $item->id;
					$id = $id['$t'];
					$full_id = (array) $item->id;
					$full_id = $id['$t'];

					// Number of days between start and end
					$span = round((strtotime($end) - strtotime($start)) / (60 * 60 * 24))+1;

					$output = str_replace(array("\r\n", "\r"), "\n", $content);
					$lines = explode("\n", $output);

					$mes = explode(",",str_replace("to","Hasta",str_replace("When","Cuando",strip_tags($lines[0]))));
					$dia = explode(",",str_replace("to","Hasta",str_replace("When","Cuando",strip_tags($lines[0]))));
					
					$events[$counter] = array(
						'id' => substr(strrchr($id, '/'), 1),
						'full_id' => $id,
						'title' => $title,
						'start' => strtotime($start),
						'end' => strtotime($end),
						'status' => $status,
						'span' => $span,
						'where' => $where,
						'content' => $content,
						'contenidocompleto' => $lines,
						'contenido' => array(
											 "cuando"=> str_replace("to","Hasta",str_replace("When","Cuando",strip_tags($lines[0]))),
											 "quien"=> str_replace("Who","Quien",strip_tags($lines[2])),
											 "donde"=> str_replace("Where","Donde",strip_tags($lines[3])),
											 "mes"=> substr(str_replace("Cuando:","",$mes[0]), 4, 6),
											 "dia"=> substr(str_replace("Cuando:","",$mes[0]), 9, 11)
											 )
					);

					$counter++;

				}

			} else {

				//echo $item->title->$t;
				$title = (array) $item->title;
				$title = $title['$t'];

				$start = $array_item['gd$when'][0]->startTime;
				$end  = $array_item['gd$when'][0]->endTime;
				$where = @$array_item['gd$where'][0]->valueString;
				$status = (strpos($array_item['gd$eventStatus']->value,"canceled") > 0 ? "canceled" : "active");
				$content = (array) $item->content;
				$content = $content['$t'];
				$id = (array) $item->id;
				$id = $id['$t'];
				$full_id = (array) $item->id;
				$full_id = $id['$t'];

				// Number of days between start and end
				$span = round((strtotime($end) - strtotime($start)) / (60 * 60 * 24))+1;

				$output = str_replace(array("\r\n", "\r"), "\n", $content);
				$lines = explode("\n", $output);
				
				$mes = explode(",",str_replace("to","Hasta",str_replace("When","Cuando",strip_tags($lines[0]))));
				$dia = explode(",",str_replace("to","Hasta",str_replace("When","Cuando",strip_tags($lines[0]))));
				
				$events[$counter] = array(
					'id' => substr(strrchr($id, '/'), 1),
					'full_id' => $id,
					'title' => $title,
					'start' => strtotime($start),
					'end' => strtotime($end),
					'status' => $status,
					'span' => $span,
					'where' => $where,
					'content' => $content,
					'contenidocompleto' => $lines,
					'contenido' => array(
										 "cuando"=> str_replace("to","Hasta",str_replace("When","Cuando",strip_tags($lines[0]))),
										 "quien"=> str_replace("Who","Quien",strip_tags($lines[2])),
										 "donde"=> str_replace("Where","Donde",strip_tags($lines[3])),
										 "mes"=> substr(str_replace("Cuando:","",$mes[0]), 5, 3),
										 "dia"=> substr(str_replace("Cuando:","",$mes[0]), 9, 11)
										 )
				);

				$counter++;

			}

		}
		$events = $this->aasort($events,'start');
		return array_values($events);

	}

}