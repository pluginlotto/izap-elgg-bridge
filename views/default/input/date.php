<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */


if(!is_numeric($vars['value'])) {
  $vars['value'] = time();
}

if(is_numeric($vars['value'])) {
  $tmp_date=date('j-n-Y', $vars['value']);
  $tmp_date=explode('-',$tmp_date);

  $vars['value']=array(
    'day'=>$tmp_date[0],
    'month'=>$tmp_date[1],
    'year'=>$tmp_date[2],
  );

  //func_printarray_byizap($vars['value']);
}

for($i=1;$i<32;$i++) :
if($i < 10) {
  $i = '0' . $i;
}
$day_arr[$i]=$i;
endfor;
echo elgg_echo('izap-elgg-bridge:date_day') . '&nbsp;/&nbsp;' . elgg_echo('izap-elgg-bridge:date_month') . '&nbsp;/&nbsp;' . elgg_echo('izap-elgg-bridge:date_year') . '<br />';

for($i=1;$i<13;$i++) :
if($i < 10) {
  $i = '0' . $i;
}
$month_arr[$i]=$i;
endfor;

for($i=($vars['params']['start_year']?$vars['params']['start_year']:1970); $i<=($vars['params']['end_year']?$vars['params']['end_year']:(date('Y',time())+10)); $i++) :
$year_arr[$i]=$i;
endfor;


echo elgg_view('input/pulldown',array('internalname'=>"{$vars['internalname']}[day]",'options_values'=>$day_arr, 'value'=>"{$vars['value']['day']}", 'internalid'=>$vars['internalid'])) . '&nbsp;/&nbsp;' .
elgg_view('input/pulldown',array('internalname'=>"{$vars['internalname']}[month]",'options_values'=>$month_arr, 'value'=>"{$vars['value']['month']}")) . '&nbsp;/&nbsp;' .
elgg_view('input/pulldown',array('internalname'=>"{$vars['internalname']}[year]",'options_values'=>$year_arr, 'value'=>"{$vars['value']['year']}")) ;