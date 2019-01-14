<?php

	$query = getVariable("query", "SELECT");
	$event = getVariable("event", "onLoad");
	$action = getVariable("action", "Ajouter");
	$id = getVariable("id");
	$di = getVariable("di");
    $grp_group = getVariable("grp_group");

    if ($event=="onLoad" && $query=="ACTION") {
        switch ($action) {
        case "Ajouter":

            $sql="select max(grp_group) from groups;";
            $stmt = $cs->query($sql);
            $rows = $stmt->fetch();
            $grp_group=$rows[0]+1;
            $grp_members_priv="";
            $grp_menu_priv="";
            $grp_page_priv="";
            $grp_news_priv="";
            $grp_items_priv="";
            $grp_customers_priv="";
            $grp_products_priv="";
            $grp_calendar_priv="";
            $grp_newsletter_priv="";
            $grp_forum_priv="";
        break;
        case "Modifier":
            $sql="select * from groups where grp_group='$grp_group';";
            $stmt = $cs->query($sql);
            $rows = $stmt->fetch(PDO::FETCH_ASSOC);
            $grp_group=$rows["grp_group"];
            $grp_members_priv=$rows["grp_members_priv"];
            $grp_menu_priv=$rows["grp_menu_priv"];
            $grp_page_priv=$rows["grp_page_priv"];
            $grp_news_priv=$rows["grp_news_priv"];
            $grp_items_priv=$rows["grp_items_priv"];
            $grp_customers_priv=$rows["grp_customers_priv"];
            $grp_products_priv=$rows["grp_products_priv"];
            $grp_calendar_priv=$rows["grp_calendar_priv"];
            $grp_newsletter_priv=$rows["grp_newsletter_priv"];
            $grp_forum_priv=$rows["grp_forum_priv"];
        break;
        }
    } elseif ($event=="onRun" && $query=="ACTION") {
        switch ($action) {
        case "Ajouter":
            $sql="insert into groups (".
                "grp_group, ".
                "grp_members_priv, ".
                "grp_menu_priv, ".
                "grp_page_priv, ".
                "grp_news_priv, ".
                "grp_items_priv, ".
                "grp_customers_priv, ".
                "grp_products_priv, ".
                "grp_calendar_priv, ".
                "grp_newsletter_priv, ".
                "grp_forum_priv".
            ") values (".
                "'$grp_group', ".
                "'$grp_members_priv', ".
                "'$grp_menu_priv', ".
                "'$grp_page_priv', ".
                "'$grp_news_priv', ".
                "'$grp_items_priv', ".
                "'$grp_customers_priv', ".
                "'$grp_products_priv', ".
                "'$grp_calendar_priv', ".
                "'$grp_newsletter_priv', ".
                "'$grp_forum_priv'".
            ")";
            $stmt = $cs->query($sql);
        break;
        case "Modifier":
            $grp_group = $_POST["grp_group"];
            $grp_members_priv = $_POST["grp_members_priv"];
            $grp_menu_priv = $_POST["grp_menu_priv"];
            $grp_page_priv = $_POST["grp_page_priv"];
            $grp_news_priv = $_POST["grp_news_priv"];
            $grp_items_priv = $_POST["grp_items_priv"];
            $grp_customers_priv = $_POST["grp_customers_priv"];
            $grp_products_priv = $_POST["grp_products_priv"];
            $grp_calendar_priv = $_POST["grp_calendar_priv"];
            $grp_newsletter_priv = $_POST["grp_newsletter_priv"];
            $grp_forum_priv = $_POST["grp_forum_priv"];
            $sql="update groups set ".
                "grp_group='$grp_group', ".
                "grp_members_priv='$grp_members_priv', ".
                "grp_menu_priv='$grp_menu_priv', ".
                "grp_page_priv='$grp_page_priv', ".
                "grp_news_priv='$grp_news_priv', ".
                "grp_items_priv='$grp_items_priv', ".
                "grp_customers_priv='$grp_customers_priv', ".
                "grp_products_priv='$grp_products_priv', ".
                "grp_calendar_priv='$grp_calendar_priv', ".
                "grp_newsletter_priv='$grp_newsletter_priv', ".
                "grp_forum_priv='$grp_forum_priv' ".
            "where grp_group='$grp_group'";
            $stmt = $cs->query($sql);
        break;
        case "Supprimer":
            $sql="delete from groups where grp_group='$grp_group'";
            $stmt = $cs->query($sql);
        break;
        }
        $query="SELECT";
    } elseif ($event=="onUnload" && $query=="ACTION") {
        $cs=connection(DISCONNECT, $database);
        echo "<script language='JavaScript'>window.location.href='page.php?id=27&lg=fr'</script>";
    }
