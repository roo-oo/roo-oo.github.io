<?php

if($_GET["search"] != NULL){

    //type
    if($_GET["work_type"] != NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] == NULL and $_GET["last_date"] == NULL){
        $work_type = $_GET["work_type"];

        $works = $db->query("select * from work, work_type 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //subtype
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] == NULL and $_GET["last_date"] == NULL){
        $work_subtype = $_GET["work_subtype"];

        $works = $db->query("select * from work, work_subtype 
                                        where work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //first_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] != NULL and $_GET["last_date"] == NULL){
        $first_date = $_GET["first_date"];

        $works = $db->query("select * from work 
                                        where date_published >= '$first_date' and user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //last_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] == NULL and $_GET["last_date"] != NULL){
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work 
                                        where date_published <= '$last_date' and user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, subtype
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] == NULL and $_GET["last_date"] == NULL){
        $work_type = $_GET["work_type"];
        $work_subtype = $_GET["work_subtype"];

        $works = $db->query("select * from work, work_type, work_subtype 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, first_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] != NULL and $_GET["last_date"] == NULL){
        $work_type = $_GET["work_type"];
        $first_date = $_GET["first_date"];

        $works = $db->query("select * from work, work_type 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work.date_published >= '$first_date' and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, last_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] == NULL and $_GET["last_date"] != NULL){
        $work_type = $_GET["work_type"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work.date_published <= '$last_date' and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //subtype, first_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] != NULL and $_GET["last_date"] == NULL){
        $work_subtype = $_GET["work_subtype"];
        $first_date = $_GET["first_date"];

        $works = $db->query("select * from work, work_subtype 
                                        where work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published >= '$first_date' and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //subtype, last_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] == NULL and $_GET["last_date"] != NULL){
        $work_subtype = $_GET["work_subtype"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_subtype 
                                        where work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published <= '$last_date' and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //first_date, last_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] != NULL and $_GET["last_date"] != NULL){
        $first_date = $_GET["first_date"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work 
                                        where date_published >= '$first_date' and date_published <= '$last_date' and user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, subtype, first_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] != NULL and $_GET["last_date"] == NULL){
        $work_type = $_GET["work_type"];
        $work_subtype = $_GET["work_subtype"];
        $first_date = $_GET["first_date"];

        $works = $db->query("select * from work, work_type, work_subtype 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published >= '$first_date' and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, subtype, last_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] == NULL and $_GET["last_date"] != NULL){
        $work_type = $_GET["work_type"];
        $work_subtype = $_GET["work_subtype"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published <= '$last_date' and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, first_date, last_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] != NULL and $_GET["last_date"] != NULL){
        $work_type = $_GET["work_type"];
        $first_date = $_GET["first_date"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work.date_published >= '$first_date' and work.date_published <= '$last_date' and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //subtype, first_date, last_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] != NULL and $_GET["last_date"] != NULL){
        $work_subtype = $_GET["work_subtype"];
        $first_date = $_GET["first_date"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_subtype 
                                        where work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published >= '$first_date' and work.date_published <= '$last_date' and and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, subtype, first_date, last_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] != NULL and $_GET["last_date"] != NULL){
        $work_type = $_GET["work_type"];
        $work_subtype = $_GET["work_subtype"];
        $first_date = $_GET["first_date"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype  
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published >= '$first_date' and work.date_published <= '$last_date' and work.user_id = $user_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }
}

if($_GET["department"] != NULL){

    //type
    if($_GET["work_type"] != NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] == NULL and $_GET["last_date"] == NULL){
        $work_type = $_GET["work_type"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id
                                        and work.subtype_id = work_subtype.subtype_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //subtype
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] == NULL and $_GET["last_date"] == NULL){
        $work_subtype = $_GET["work_subtype"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info 
                                        where work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and
                                        work.type_id = work_type.type_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //first_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] != NULL and $_GET["last_date"] == NULL){
        $first_date = $_GET["first_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info
                                        where work.date_published >= '$first_date' and
                                        work.type_id = work_type.type_id and work.subtype_id = work_subtype.subtype_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //last_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] == NULL and $_GET["last_date"] != NULL){
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info 
                                        where work.date_published <= '$last_date' and
                                        work.type_id = work_type.type_id and work.subtype_id = work_subtype.subtype_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, subtype
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] == NULL and $_GET["last_date"] == NULL){
        $work_type = $_GET["work_type"];
        $work_subtype = $_GET["work_subtype"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and
                                        work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, first_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] != NULL and $_GET["last_date"] == NULL){
        $work_type = $_GET["work_type"];
        $first_date = $_GET["first_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work.date_published >= '$first_date' and
                                        work.subtype_id = work_subtype.subtype_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, last_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] == NULL and $_GET["last_date"] != NULL){
        $work_type = $_GET["work_type"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work.date_published <= '$last_date' and
                                        work.subtype_id = work_subtype.subtype_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //subtype, first_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] != NULL and $_GET["last_date"] == NULL){
        $work_subtype = $_GET["work_subtype"];
        $first_date = $_GET["first_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info 
                                        where work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published >= '$first_date' and
                                        work.type_id = work_type.type_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //subtype, last_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] == NULL and $_GET["last_date"] != NULL){
        $work_subtype = $_GET["work_subtype"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info
                                        where work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published <= '$last_date' and
                                        work.type_id = work_type.type_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //first_date, last_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] != NULL and $_GET["last_date"] != NULL){
        $first_date = $_GET["first_date"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info 
                                        where work.date_published >= '$first_date' and work.date_published <= '$last_date' and
                                        work.type_id = work_type.type_id and work.subtype_id = work_subtype.subtype_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, subtype, first_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] != NULL and $_GET["last_date"] == NULL){
        $work_type = $_GET["work_type"];
        $work_subtype = $_GET["work_subtype"];
        $first_date = $_GET["first_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published >= '$first_date' and
                                        work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, subtype, last_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] == NULL and $_GET["last_date"] != NULL){
        $work_type = $_GET["work_type"];
        $work_subtype = $_GET["work_subtype"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published <= '$last_date' and
                                        work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, first_date, last_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] == NULL and $_GET["first_date"] != NULL and $_GET["last_date"] != NULL){
        $work_type = $_GET["work_type"];
        $first_date = $_GET["first_date"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work.date_published >= '$first_date' and work.date_published <= '$last_date' and
                                        work.subtype_id = work_subtype.subtype_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //subtype, first_date, last_date
    elseif($_GET["work_type"] == NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] != NULL and $_GET["last_date"] != NULL){
        $work_subtype = $_GET["work_subtype"];
        $first_date = $_GET["first_date"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info
                                        where work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published >= '$first_date' and work.date_published <= '$last_date' and
                                        work.type_id = work_type.type_id and work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }

    //type, subtype, first_date, last_date
    elseif($_GET["work_type"] != NULL and $_GET["work_subtype"] != NULL and $_GET["first_date"] != NULL and $_GET["last_date"] != NULL){
        $work_type = $_GET["work_type"];
        $work_subtype = $_GET["work_subtype"];
        $first_date = $_GET["first_date"];
        $last_date = $_GET["last_date"];

        $works = $db->query("select * from work, work_type, work_subtype, work_kind, work_language, user_info 
                                        where work_type.type_name = '$work_type' and work.type_id = work_type.type_id and work_subtype.subtype_name = '$work_subtype' and work.subtype_id = work_subtype.subtype_id and work.date_published >= '$first_date' and work.date_published <= '$last_date' and
                                        work.kind_id = work_kind.kind_id and work.language_id = work_language.language_id and user_info.user_id = work.user_id and user_info.department_id = $department_id
                                        order by work.work_name");
        $works->setFetchMode(PDO::FETCH_ASSOC);
        $work = $works->fetchAll();
    }
}


