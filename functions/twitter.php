<?php 
// Função para exibir os últimos tweets de um usuario do Twitter
function twitter_list($usernames, $limit, $show) {
 
    $prefix = "<ul class='twitter_list'>"; // This comes before the entire block of tweets.
	$prefix_sub = "<li>"; // This comes before each tweet on the feed.
	$wedge = "<br />"; // This comes after the username but before the tweet content.
	$suffix_sub = "</li>"; // This comes after each tweet on the feed.
	$suffix = "</ul>"; // This comes after the entire block of tweets.
	$usernames = str_replace(" ", "+OR+from%3A", $usernames);
    $feed = "http://search.twitter.com/search.atom?q=from%3A" . $usernames . "&rpp=" . $limit;
    $feed = wp_remote_fopen($feed);
    $feed = str_replace("&", "&", $feed);
    $feed = str_replace("<", "<", $feed);
    $feed = str_replace(">", ">", $feed);
    $clean = explode("<entry>", $feed);
    $amount = count($clean) - 1;
 
 	echo $prefix;
    for ($i = 1; $i <= $amount; $i++) {
 
    	$entry_close = explode("</entry>", $clean[$i]);
    	$clean_content_1 = explode("<content type=\"html\">", $entry_close[0]);
    	$clean_content = explode("</content>", $clean_content_1[1]);
    	$clean_name_2 = explode("<name>", $entry_close[0]);
    	$clean_name_1 = explode("(", $clean_name_2[1]);
    	$clean_name = explode(")</name>", $clean_name_1[1]);
    	$clean_uri_1 = explode("<uri>", $entry_close[0]);
    	$clean_uri = explode("</uri>", $clean_uri_1[1]);
 
    	// Make the links clickable and take care quote & apostrophe
 
    	$clean_content[0] = str_replace("&lt;", "<", $clean_content[0]); 
    	$clean_content[0] = str_replace("&gt;", ">", $clean_content[0]); 
    	$clean_content[0] = str_replace("&amp;", "&", $clean_content[0]); 
    	$clean_content[0] = str_replace("&quot;", "\"", $clean_content[0]);
    	$clean_content[0] = str_replace("&apos;", "'", $clean_content[0]);
 
    	echo $prefix_sub;
 
    	if ($show == 1) { 
    		echo  "<a href=\"" . $clean_uri[0] . "\" class=\"twitterlink\">" . $clean_name[0] . "</a>" . $wedge; 
    	}
    	echo $clean_content[0];
    	echo $suffix_sub;
    }
	echo $suffix;
}
?>