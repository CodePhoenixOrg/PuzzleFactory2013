<center>
<?php
    use Phink\Log\TLog;
    use \Puzzle\Data\Controls as DataControls;
    use \Puzzle\Design;

    $cs = connection(CONNECT, $database);
    $datacontrols = new DataControls($lg, $db_prefix);
    $design = new Design();

    $sql = 'select nw_id, nw_url, concat(\'<span style=\"font-size:12; font-weight:bold\">\', nw_title, \'</span><br><span style=\"font-size:12; font-style:normal\">\', nw_text, \'</span><br><span style=\"font-size:10; font-style:italic; text-align:right\">\', nw_author, \', \', nw_date, \' @ \', nw_time, \'</span>\') as News from '.$db_prefix.'news order by nw_date desc, nw_time desc';
    TLog::create()->debug("SQL : " . __FILE__ . ":" . __LINE__, $sql);

// DEBUG
/* begin
    $lb="FROM NEWS.PHP:\n";
    $fh=fopen("./query.txt", "a");
    fwrite($fh, $lb.$sql."\n\n");
    fclose($fh);
end*/
    
    $step=5;
    $dialog=0;
    $image_lien="";
    $compl_url="";
    $col_largeurs=array(0, 100 ,470);
    
    $dbgrid = $datacontrols->createPagerDbGrid("news", $sql, "compnews", "&nw_url", "&nw=#nw_id$compl_url", "", false, false, $dialog, $col_largeurs, 5, $grid_colors, $cs);
        
    $dbgrid=$design->tableShadow("news", $dbgrid);
    echo $dbgrid;

/*

        if($author!="none")
            $author="Auteur : $author";
        else
            $author="";

        if($date!="01/01/2003")
            $datetime="Date : $date $time";
        else
            $datetime="";


        if($author!="")
            $author_datetime="$author - $datetime";
        else
            $author_datetime="$datetime";
        if($author_datetime!="") $author_datetime.="<br>\n";

*/
    
    
    
    



?>	
</center>
