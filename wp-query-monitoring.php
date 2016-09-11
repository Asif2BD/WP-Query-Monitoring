<?php
/*
Plugin Name: WP Query Monitoring
Description: Monitor wordpress databse query and shows them in footer. To see result add a query parameter query_monitor=yes with the URL. eg: example.com/?query_monitor=yes
Author: ARCom
Author URI: http://arcom.com.bd
Version: 1.0
*/
 $qm_num_exicuted_queries;
 $qm_exicuted_queries=array();
 function wpQueryMonitor($query)
 {
 global $qm_num_exicuted_queries, $qm_exicuted_queries;
 $qm_num_exicuted_queries++;
  $qm_exicuted_queries[]=$query;
 return $query; 
 }
 if(isset($_GET['query_monitor']))
 {
 add_filter('query','wpQueryMonitor');
 add_action('shutdown', 'wpqm_shutdown', 30);
 }
 function wpqm_shutdown()
 {
		echo '<div style="min-height:200px; border:2px solid #CC0000;"><h3>Query Monitoring</h3>';
		global $qm_num_exicuted_queries, $qm_exicuted_queries;
		echo "Total Query: ".get_num_queries(); echo " queries  "; timer_stop(1); echo " Second<br> ";
		echo "Query Count By Filter: ".$qm_num_exicuted_queries; 
		echo "<pre>"; print_r($qm_exicuted_queries); echo "</pre>";
		echo "<br>----------------------------PROCESS LIST---------------------------------------------<br>";
		$pro=@mysql_query("SHOW FULL PROCESSLIST");
		while($process=mysql_fetch_assoc($pro))
		{
		echo "<pre>"; print_r($process); echo "</pre>";
		}
		echo '</div>';
 }
?>