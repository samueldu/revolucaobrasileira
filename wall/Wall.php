<?php
/*
Paid WallScript Version: A 99Points Blog Production
You are using a paid script bought from 99Points
Created by: Zeeshan Rasool - www.99Points.info
*/
require_once 'newCon.php';
include_once ('text.php');

class Wall {

    public function getOrigemName($id,$origem)
    {

        GLOBAL $wallUrl;
        GLOBAL $siteUrl;

        $select = "select * from wallplaces where id = '".$origem."'";

        $return = mysql_query($select);

        $return = mysql_fetch_array($return);

        $link = "";

        if ($return['wallplace'] == "politico") {
            $link = "<a href=\"".$siteUrl."../politico/politico?politicoid=".$id."\" target=\"_parent\" style=\"float:left\">no perfil de um político</a>";
        } elseif ($return['wallplace'] == "wall de amigo") {
            $link = "<a href=\"".$wallUrl."id_wall=".$id."&origem=4&id=\" target=\"_parent\" style=\"float:left\">no perfil de um político</a>";
        } elseif ($return['wallplace'] == "noticia") {
            $link = "<a href=\"".$siteUrl."../materias/materias?materia_id=".$id."\" target=\"_parent\" style=\"float:left\">em uma notícia</a>";
        } elseif ($return['wallplace'] == "wall") {
            $link = "<a href=\"".$wallUrl."?id_wall=".$id."&origem=4&id=\" target=\"_parent\" style=\"float:left\">no perfil de um amigo</a>";
        }

        print $link;
    }

	public function PublishToWall( $Post = "", $posted_on, $user_id = 0, $title = "", $url = "", $description = "", $cur_image = "", $post_type = 0, $videoType = 0, $youtube = "", $media=0, $tagged=false,$origem='1') 
	{

		$Post  	= $this->filterData( $Post );
		$title 	= $this->filterData( $title );
		$description = $this->filterData( $description );
		$url 	= $this->filterData( $url );
		$tagged_array=explode(',',$tagged);
		$tags=implode(',', $tagged_array);
		
		mysql_query("INSERT INTO wallposts (post,userid,date_created,posted_by,title,url,description,cur_image,post_type,value,youtube,media,tagedpersons,origem) 
		VALUES 
		('".$Post."','".$posted_on."','".strtotime(date("Y-m-d H:i:s"))."','".$user_id."','".$title."','".$url."','".$description."','".$cur_image."','".$post_type."','".$videoType."','".$youtube."','".$media."','".$tags."','".$origem."')") or die(mysql_error());
	}


    function GetSingleDebate( $user_id,$dois,$tres,$quatro)
    {
        $qry = "SELECT DISTINCT wallposts.p_id, customer.facebook_id as facebook_id, customer.twitter_id as twitter_id, customer.firstname as firstname, customer.lastname as lastname,wallposts.uip,wallposts.userid,wallposts.youtube,wallposts.media,wallposts.tagedpersons,wallposts.post_type,wallposts.type,wallposts.posted_by,wallposts.post as postdata,wallposts.title,wallposts.url,wallposts.description as description,wallposts.cur_image, UNIX_TIMESTAMP() - wallposts.date_created AS TimeSpent,wallposts.date_created
        FROM wallposts
        inner join customer on customer.customer_id = wallposts.userid
        where wallposts.p_id = ".$quatro." order by wallposts.p_id desc limit 1";
        $res = mysql_query($qry);
        return $res;
    }
	
	function GetSinglePost( $user_id)
	{
		$qry = "SELECT DISTINCT wallposts.p_id,wallposts.uip,wallposts.userid,wallposts.youtube,wallposts.media,wallposts.tagedpersons,wallposts.post_type,wallposts.type,wallposts.posted_by,wallposts.post as postdata,wallposts.title,wallposts.url,wallposts.description,wallposts.cur_image, UNIX_TIMESTAMP() - wallposts.date_created AS TimeSpent,wallposts.date_created FROM wallposts where wallposts.posted_by=".$user_id." order by wallposts.p_id desc limit 1";
		$res = mysql_query($qry);
		return $res;
	}
	
	function GetPublicPosts( $matches, $user_id, $show_more_post )
	{
		$qry = "SELECT DISTINCT wallposts.p_id,wallposts.type,wallposts.value,wallposts.media,wallposts.youtube,wallposts.post_type,wallposts.tagedpersons,wallposts.title,wallposts.url,wallposts.description,wallposts.cur_image,wallposts.uip,wallposts.likes,wallposts.userid,wallposts.posted_by,wallposts.post as postdata, UNIX_TIMESTAMP() - wallposts.date_created AS TimeSpent,wallposts.date_created
		FROM wallposts,customer
		where (customer.customer_id IN (".$matches.") and customer.customer_id = wallposts.userid
		order by wallposts.p_id desc limit ".$show_more_post.", 10";
		
		//print $qry;
		//print $show_more_post;
		
		$res = mysql_query($qry);
		return $res;
	}
	
	function GetPublicPostsNext( $matches, $user_id, $next_records )
	{
		$qry = "SELECT DISTINCT wallposts.p_id, wallposts.origem as origem, wallposts.userid,wallposts.posted_by,wallposts.post as postdata,customer,wallposts.date_created
		FROM wallposts,customer 
		where (customer.customer_id IN (".$matches.") OR customer.customer_id =".$user_id.") and customer.customer_id = wallposts.userid 
		order by wallposts.p_id desc 
		limit ".$next_records.", 10";  
        
		
		$res = mysql_query($qry);
		return @mysql_num_rows($res);
	}
	
	
	function GetMyPostsNextTotal( $user_id, $show_more_post,$origem,$id_wall )
	{
	
	/*        $qry = "SELECT DISTINCT wallposts.p_id,wallposts.type,wallposts.value,wallposts.media,wallposts.youtube,wallposts.post_type,wallposts.title,wallposts.tagedpersons,wallposts.url,wallposts.description,wallposts.cur_image,wallposts.uip,wallposts.likes,wallposts.userid,wallposts.posted_by,wallposts.post as postdata,wallusers.*, UNIX_TIMESTAMP() - wallposts.date_created AS TimeSpent,wallposts.date_created FROM wallposts,wallusers where wallusers.mem_id =".$user_id." and wallusers.mem_id =wallposts.userid order by wallposts.p_id desc limit ".$show_more_post.", 10";
	*/
	
		$qry = "SELECT DISTINCT wallposts.p_id, wallposts.origem as origem, wallposts.type,wallposts.value,wallposts.media,wallposts.youtube,wallposts.post_type,
		wallposts.title,wallposts.tagedpersons,wallposts.url,wallposts.description,wallposts.cur_image,wallposts.uip,
		wallposts.likes,wallposts.userid,wallposts.posted_by,wallposts.post as postdata, UNIX_TIMESTAMP() - wallposts.date_created AS TimeSpent,wallposts.date_created 
		FROM wallposts 
		where wallposts.userid = '".$user_id."' and wallposts.origem='".$origem."' 
		order by wallposts.p_id desc limit ".$show_more_post.", 10";
		//print $qry;
		//exit;
		$res = mysql_query($qry);
		return $res;
	}
	
	function GetMyPosts( $user_id, $show_more_post,$origem,$id_wall )
	{
	
	/*        $qry = "SELECT DISTINCT wallposts.p_id,wallposts.type,wallposts.value,wallposts.media,wallposts.youtube,wallposts.post_type,wallposts.title,wallposts.tagedpersons,wallposts.url,wallposts.description,wallposts.cur_image,wallposts.uip,wallposts.likes,wallposts.userid,wallposts.posted_by,wallposts.post as postdata,wallusers.*, UNIX_TIMESTAMP() - wallposts.date_created AS TimeSpent,wallposts.date_created FROM wallposts,wallusers where wallusers.mem_id =".$user_id." and wallusers.mem_id =wallposts.userid order by wallposts.p_id desc limit ".$show_more_post.", 10";
	*/


		$qry = "SELECT customer.lastname as lastname, facebook_id,twitter_id, wallposts.origem as origem, customer.firstname as firstname, wallposts.p_id,wallposts.type,wallposts.value,wallposts.media,wallposts.youtube,wallposts.post_type,
		wallposts.title,wallposts.tagedpersons,wallposts.url,wallposts.description,wallposts.cur_image,wallposts.uip,
		wallposts.likes,wallposts.userid,wallposts.posted_by,wallposts.post as postdata, UNIX_TIMESTAMP() - wallposts.date_created AS TimeSpent,wallposts.date_created 
		FROM wallposts
		left join customer on customer.customer_id ='".$user_id."'
		where ((wallposts.userid = '".$id_wall."' or wallposts.posted_by = '".$id_wall."') and wallposts.origem != '7')
		order by wallposts.p_id desc limit ".$show_more_post.", 10";

        //print $qry;
        //and (wallposts.origem='".$origem."' or wallposts.origem='3')

		$res = mysql_query($qry) or die(mysql_error());
		return $res;
	}
	
	function GetMyPostsNext( $user_id, $next_records,$origem,$id_wall )
	{
	
		$qry = "SELECT DISTINCT wallposts.p_id,wallposts.origem as origem,wallposts.userid,wallposts.posted_by,wallposts.post as postdata
		FROM wallposts
		where wallposts.userid = '$user_id'  order by wallposts.p_id desc limit ".$next_records.", 10";
		
		//print $qry;
        //and wallposts.origem='".$origem."'
		
		$res = mysql_query($qry);
		return @mysql_num_rows($res);
	}
	
	public function PublishComment( $comment_text = "", $post_id = 0, $user_id = 0, $tagged=false,$answer)
	{	
		$comment_text = $this->filterData( $comment_text );
		
		$tagged_array=explode(',',$_REQUEST['Tagged']);
		$tags=implode(',', $tagged_array);
		
		mysql_query("INSERT INTO wallcomments (post_id, comments, userid, date_created, tagedpersons, answer) VALUES(".$post_id.",'".$comment_text."',".$user_id.",'".strtotime(date("Y-m-d H:i:s"))."','".$tags."','".$answer."')");
	}
	
	function filterData($value)
	{
		// Trim the value
		$value = trim($value);
		// Stripslashes
		if (get_magic_quotes_gpc()) 
		{
			$value = stripslashes($value);
		}
		// Strip HTML Tags
		$value = strip_tags($value);
		// Quote the value
		$value = mysql_real_escape_string($value);
		$value = htmlspecialchars ($value);
		return $value;		
	}	
	
	function getAvatar($user_id = '',&$row='')
	{	

		$username_get = mysql_query("SELECT mem_pic,gender,'123' as oauth_uid from wallusers where mem_id=".$user_id." order by mem_id desc limit 1");
		while ($name = @mysql_fetch_array($username_get))
		{
			$mem_pic = $name['mem_pic'];
			$gender = $name['gender'];
			$oauth_uid = $name['oauth_uid'];
		}
		
		if(isset($oauth_uid) and $oauth_uid > 0)
		{
			$imageUser = $mem_pic;
			if (@$mem_pic=='')  
			{
				if(@$gender == 'm')
				$imageUser = 'pics/no-image-m.png';
				else
				$imageUser = 'pics/no-image-f.png';
			}
		}
		else
		{
			$imageUser = 'pics/'.@$mem_pic;
		
			if (!file_exists($imageUser) || @$mem_pic=='')  
			{
				if(@$gender == 'm')
				$imageUser = 'pics/no-image-m.png';
				else
				$imageUser = 'pics/no-image-f.png';
                
                $imageUser = 'pics/no-image-m.png';
			}
		}
        
        if(isset($row['facebook_id']))
        $imageUser = "https://graph.facebook.com/".$row['facebook_id']."/picture?width=50&height=50";
        
		return  $imageUser;
	}

	// Check if user like this wallpost or not...:
	
	// Get the comments...:
	public function GetComments($wallId, $show_comments_per_page, $sort = "desc") 
	{
		$sql = "SELECT t1.*,t2.*,UNIX_TIMESTAMP() - t1.date_created AS CommentTimeSpent 
		FROM wallcomments as t1,
		customer as t2 
		where t1.post_id = ".$wallId." AND t1.userid=t2.customer_id order by t1.c_id $sort limit 0,$show_comments_per_page ";
		
		//print $sql;
		
		$res = mysql_query( $sql);
		
		return $res;
	}
	
	public function CountComments($wallId){
		
		/*
		$sql = "SELECT t1.userid,t1.post_id,t1.c_id,t2.mem_pic,t2.mem_id FROM wallcomments as t1,
		customer as t2 where t1.post_id = ".$wallId." AND t1.userid = t2.customer_id order by t1.c_id asc";
		*/
		
				$sql = "SELECT t1.userid,t1.post_id,t1.c_id,t2.customer_id FROM wallcomments as t1,
		customer as t2 where t1.post_id = ".$wallId." AND t1.userid = t2.customer_id order by t1.c_id asc";
		
		
		//print $sql;
		
		$count = mysql_query( $sql);
		return (@mysql_num_rows($count) ? @mysql_num_rows($count) : 0);
	}

    public function CountCommentsDebate($wallId){

        $sql = "SELECT count(*)as total,t1.answer,t1.userid,t1.post_id,t1.c_id, t2.customer_id
        FROM wallcomments as t1,
		customer as t2
		WHERE t1.post_id = ".$wallId." AND t1.userid = t2.customer_id
		GROUP BY t1.answer
		ORDER BY t1.c_id asc";

        //print $sql;

        $count = mysql_query( $sql);

        $dados[1]=0;
        $dados[0]=0;

        while ($row = mysql_fetch_assoc($count))
        {
            $dados[$row['answer']] = $row['total'];
        }

        return $dados;
    }

	public function DeleteWallPost($id) {
	
		$id = mysql_real_escape_string($id);	

		$nResults = mysql_query("select cur_image,post_type from wallposts where p_id ='".$id."' and post_type=2");
		if (mysql_num_rows($nResults))
		{
			while ($row = mysql_fetch_assoc($nResults)) 
			{
				if( $row['cur_image'] != '')
				{
					@unlink('media/'.$row['cur_image']);
				}
			}
		}
		
		mysql_query("delete from wallposts where p_id ='".$id."'");
		mysql_query("delete from wallcomments where post_id ='".$id."'");
	}
		
	public function DeleteCommment($commentId)
	{
		$sql ="DELETE FROM wallcomments WHERE c_id = '$commentId' LIMIT 1";
		mysql_query($sql);
	}
	
	// Tagging friends...:
	public function tagfunc($pdata, $tagged=false)
	{
		$tagged   = explode(",", $tagged);
		
		$all_tags = $this->getparsedall( $pdata, '[', ']' );
		
		if(!empty($all_tags))
		{
			for ( $i = 0; $i < sizeof( $all_tags ); $i++ )
			{
				$v = '';
				$v = trim( $all_tags[$i] );
				
				$pdata = str_replace('['.$v.']', '<a href="profile.php?id='.$tagged[$i].'">'.$v.'</a>', $pdata);
			}
		}
		
		return $pdata;
	}
	
	public function getparsedall($string,$start,$end)
	{
		//Returns an array of all values which are between two tags in a set of data
		$strings = array();
		$startPos = 0;
		$i = 0;
		$string = '_(Cc)_(CT)_ '.$string;
		//echo strlen($string)."\n";
		while($startPos < strlen($string) && $matched = @$this->getparsed(substr($string,$startPos),$start,$end))
		{
			if ($matched == null || $matched[1] == null || $matched[1] == '') break;
				$startPos = $matched[0]+$startPos+1;
			array_push($strings,$matched[1]);
			$i++;
		}
		
		return $strings;
	}

	public function getparsed($string, $start, $end)
	{	
		$ini = strpos($string,$start);
		if ($ini == 0) return null;
			$ini += strlen($start);
			
		$len = strpos($string,$end,$ini) - $ini;
		return array($ini+$len,substr($string,$ini,$len));
	}
	
	/// remove img url
	public function getparsedandremoveUrl($string,$start,$end)
	{	
		$strings = array();
		$startPos = 0;
		$string_n = "";
		$i = 0;
		$string_n = $string;
		//echo strlen($string)."\n";
		while($startPos < strlen($string) && $matched = @$this->getparsed(substr($string,$startPos),$start,$end))
		{
			if ($matched == null || $matched[1] == null || $matched[1] == '') break;
				$startPos = $matched[0]+$startPos+1;
				//echo $matched[1];
				$r= $start.$matched[1].$end;
				$string_n = str_replace($r," ", $string_n);
				array_push($strings,$matched[1]);
			$i++;
		}
		return $string_n;
	}

	public function clickable_link($text = '')
	{	
		$text = preg_replace('#(script|about|applet|activex|chrome):#is', "\\1:", $text);
		$ret = ' ' . $text;
		$ret = preg_replace("#(^|[\n ])([\w]+?://[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"\\2\" target=\"_blank\" rel=\"no_follow\">\\2</a>", $ret);
		
		$ret = preg_replace("#(^|[\n ])((www|ftp)\.[\w\#$%&~/.\-;:=,?@\[\]+]*)#is", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $ret);
		$ret = preg_replace("#(^|[\n ])([a-z0-9&\-_.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
		$ret = substr($ret, 1);
		return $ret;
	}

	// Get user details...:
	function getuserinformation($mem_id=0)
	{
		$nResults = mysql_query("SELECT *, customer_id as id,facebook_id,twitter_id from customer where customer.customer_id='".$mem_id."' limit 1");
		return mysql_fetch_array($nResults);
	}
	
	/* alterado de walluser para politicos */
	function getUserId($username = "")
	{ 
	
		$nResults = mysql_query("SELECT * from customer where customer_id = ".$username." limit 1");
		if (@mysql_num_rows($nResults))
		{
			while ($name = @mysql_fetch_array($nResults))
			{
				$mem_id['customer_id'] = $name['customer_id'];
                $mem_id['facebook_id'] = $name['facebook_id'];
                $mem_id['twitter_id'] = $name['twitter_id'];
			}
			return $mem_id;
		}
		else
		{
			return 0;	
		}
	}
	
	public function add_smileys($string)
	{
		$string = preg_replace('/(\s|^)(:pedobear:)/i', ' <img src="smileys/pedobear.png" alt="pedobear" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:awesome:)/i', ' <img src="smileys/awesome.png" alt="awesome" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:roll:)/i', ' <img src="smileys/roll.gif" alt="rolleyes" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:-{0,1}\\\|;-{0,1}\\\|:-\/|:-{0,1}S|:-{0,1}\?)/', ' <img src="smileys/confused.png" alt="confused" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:-{0,1}\()/i', ' <img src="smileys/sad.png" alt="sad" width="16" height="16" title="$1" />', $string);
		$string = preg_replace('/(\s|^)(:-{0,1}D)/i', ' <img src="smileys/grin.png" alt="grin" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:-{0,1}O)/i', ' <img src="smileys/surprised.png" alt="surprised" title="$1"  width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:-{0,1}\))/i', ' <img src="smileys/smile.png" alt="smile" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(;-{0,1}\))/i', ' <img src="smileys/wink.png" alt="wink" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(\^\^)/i', ' <img src="smileys/happy.png" alt="happy" title="$1"  width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(¬¬)/i', ' <img src="smileys/annoyed.png" alt="¬¬" title="$1"  width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(8-{0,1}\))/i', ' <img src="smileys/cool.png" alt="cool" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:-{0,1}P)/i', ' <img src="smileys/tongue.png" alt="tongue" title="$1"  width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:\'-{0,1}\()/i', ' <img src="smileys/cry.png" alt="cry" title="$1"  width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:\'-{0,1}\))/i', ' <img src="smileys/yay.png" alt="yay" title="$1"  width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(x-{0,1}D)/i', ' <img src="smileyslaugh.png" alt="laugh" title="$1"  width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:-{0,1}\|)/i', ' <img src="smileys/neutral.png" alt="neutral" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:-{0,1}\@)/i', ' <img src="smileys/furious.png" alt="furious" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(:-{0,1}\*)/i', ' <img src="smileys/kiss.png" alt="kiss" title="$1" width="16" height="16" />', $string);
		$string = preg_replace('/(\s|^)(\(L\))/i', ' <img src="smileys/heart.png" alt="love" title="$1" width="16" height="16" />', $string);
		return $string;
	}

	function returnFreinds($user_id)
	{
		$recget = mysql_query("SELECT * FROM wallusers INNER JOIN wallfriends ON wallusers.mem_id = wallfriends.mem_id_from WHERE wallfriends.mem_id_to=".$user_id." and wallfriends.confirm=1");
		
		$friends_list = array();
		
		if (@mysql_num_rows($recget))
		{
			while ($named = @mysql_fetch_array($recget))
			{
				array_push($friends_list, $named['mem_id_from']);
			}
			
			$matches = implode(',', $friends_list);
		}
		else 
			$matches = 0;
		return $matches;
	}
	
}?>