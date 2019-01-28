<?php

	$query = getArgument("query", "SELECT");
	$event = getArgument("event", "onLoad");
	$action = getArgument("action", "Ajouter");
	$id = getArgument("id");
	$di = getArgument("di");
    $grp_group = getArgument("grp_group");

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
            $grp_group = filterPOST("grp_group");
            $grp_members_priv = filterPOST("grp_members_priv");
            $grp_menu_priv = filterPOST("grp_menu_priv");
            $grp_page_priv = filterPOST("grp_page_priv");
            $grp_news_priv = filterPOST("grp_news_priv");
            $grp_items_priv = filterPOST("grp_items_priv");
            $grp_customers_priv = filterPOST("grp_customers_priv");
            $grp_products_priv = filterPOST("grp_products_priv");
            $grp_calendar_priv = filterPOST("grp_calendar_priv");
            $grp_newsletter_priv = filterPOST("grp_newsletter_priv");
            $grp_forum_priv = filterPOST("grp_forum_priv");
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
