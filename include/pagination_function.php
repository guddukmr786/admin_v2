<?php
require_once('config.php');

class PaginationFunction 
{
    
    function __construct()
    {
        $this->db = new Database();
    }



    function displayPaginationBelow($per_page,$page, $hotel_id){
        
        $page_url="?";

        $query = "SELECT COUNT(*) as totalCount FROM check_in_details WHERE hotel_id = '$hotel_id'";
        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);

        $total = $rec['totalCount'];


        $adjacents = "2"; 



        $page = ($page == 0 ? 1 : $page);  

        $start = ($page - 1) * $per_page;                               

        

        $prev = $page - 1;                          

        $next = $page + 1;

        $setLastpage = ceil($total/$per_page);

        $lpm1 = $setLastpage - 1;

        

        $setPaginate = "";

        if($setLastpage > 1)

        {   

            $setPaginate .= "<ul class='setPaginate'>";

                    $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";

            if ($setLastpage < 7 + ($adjacents * 2))

            {   

                for ($counter = 1; $counter <= $setLastpage; $counter++)

                {

                    if ($counter == $page)

                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                    else

                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                }

            }

            elseif($setLastpage > 5 + ($adjacents * 2))

            {

                if($page < 1 + ($adjacents * 2))        

                {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>...</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>..</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                else

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                }

            }

            

            if ($page < $counter - 1){ 

                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";

                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";

            }else{

                $setPaginate.= "<li><a class='current_page'>Next</a></li>";

                $setPaginate.= "<li><a class='current_page'>Last</a></li>";

            }



            $setPaginate.= "</ul>\n";       

        }

    

    

        return $setPaginate;

    } 


    function displayBookingListPagination($per_page,$page, $hotel_id){
        $page_url="?";
        $crr_date = CURR_DATE;
        $query = "SELECT COUNT(*) as totalCount FROM arrival_booking_history WHERE hotel_id = '$hotel_id' AND status = 0 AND checkin_date = '$crr_date'";

        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);
        $total = $rec['totalCount'];
        $adjacents = "2"; 

        $page = ($page == 0 ? 1 : $page);  
        $start = ($page - 1) * $per_page;                               

        $prev = $page - 1;                          
        $next = $page + 1;
        $setLastpage = ceil($total/$per_page);
        $lpm1 = $setLastpage - 1;
        

        $setPaginate = "";
        if($setLastpage > 1) {   
            $setPaginate .= "<ul class='setPaginate'>";
            $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
            if ($setLastpage < 7 + ($adjacents * 2)) {   
                for ($counter = 1; $counter <= $setLastpage; $counter++)
                {
                    if ($counter == $page)
                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                    else
                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                }

            } elseif($setLastpage > 5 + ($adjacents * 2)) {
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
                    {
                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }

                    $setPaginate.= "<li class='dot'>...</li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                } elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>..</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                } else {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++) {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                }

            }

            if ($page < $counter - 1){ 

                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";

                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";

            }else{

                $setPaginate.= "<li><a class='current_page'>Next</a></li>";

                $setPaginate.= "<li><a class='current_page'>Last</a></li>";

            }

            $setPaginate.= "</ul>\n";       

        }
        return $setPaginate;

    } 


    function displayPaginationBelowDayBookList($per_page,$page, $hotel_id){

        $page_url="?";
        $date1 = CURR_DATE1;
        $query = "SELECT COUNT(*) as totalCount FROM day_book_entry WHERE hotel_id = '$hotel_id' AND date_of_expense = '$date1'";

        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);

        $total = $rec['totalCount'];

        $adjacents = "2"; 



        $page = ($page == 0 ? 1 : $page);  

        $start = ($page - 1) * $per_page;                               

        

        $prev = $page - 1;                          

        $next = $page + 1;

        $setLastpage = ceil($total/$per_page);

        $lpm1 = $setLastpage - 1;

        

        $setPaginate = "";

        if($setLastpage > 1)

        {   

            $setPaginate .= "<ul class='setPaginate'>";

                    $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";

            if ($setLastpage < 7 + ($adjacents * 2))

            {   

                for ($counter = 1; $counter <= $setLastpage; $counter++)

                {

                    if ($counter == $page)

                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                    else

                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                }

            }

            elseif($setLastpage > 5 + ($adjacents * 2))

            {

                if($page < 1 + ($adjacents * 2))        

                {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>...</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>..</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                else

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                }

            }

            

            if ($page < $counter - 1){ 

                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";

                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";

            }else{

                $setPaginate.= "<li><a class='current_page'>Next</a></li>";

                $setPaginate.= "<li><a class='current_page'>Last</a></li>";

            }



            $setPaginate.= "</ul>\n";       

        }

    

    

        return $setPaginate;

    } 


    function displayPaginationBelowEmployeeDetails($per_page,$page, $hotel_id){

        $page_url="?";
        $date1 = CURR_DATE1;
        $query = "SELECT COUNT(*) as totalCount FROM employees WHERE hotel_id = '$hotel_id' AND date_of_join = '$date1'";

        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);

        $total = $rec['totalCount'];

        $adjacents = "2"; 



        $page = ($page == 0 ? 1 : $page);  

        $start = ($page - 1) * $per_page;                               

        

        $prev = $page - 1;                          

        $next = $page + 1;

        $setLastpage = ceil($total/$per_page);

        $lpm1 = $setLastpage - 1;

        

        $setPaginate = "";

        if($setLastpage > 1)

        {   

            $setPaginate .= "<ul class='setPaginate'>";

                    $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";

            if ($setLastpage < 7 + ($adjacents * 2))

            {   

                for ($counter = 1; $counter <= $setLastpage; $counter++)

                {

                    if ($counter == $page)

                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                    else

                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                }

            }

            elseif($setLastpage > 5 + ($adjacents * 2))

            {

                if($page < 1 + ($adjacents * 2))        

                {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>...</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>..</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                else

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                }

            }

            

            if ($page < $counter - 1){ 

                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";

                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";

            }else{

                $setPaginate.= "<li><a class='current_page'>Next</a></li>";

                $setPaginate.= "<li><a class='current_page'>Last</a></li>";

            }



            $setPaginate.= "</ul>\n";       

        }


        return $setPaginate;

    }

    function displayTravelPagination($per_page,$page){

        $page_url="?";
        
        $query = "SELECT COUNT(*) as totalCount FROM travel_details";

        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);

        $total = $rec['totalCount'];

        $adjacents = "2"; 



        $page = ($page == 0 ? 1 : $page);  

        $start = ($page - 1) * $per_page;                               

        

        $prev = $page - 1;                          

        $next = $page + 1;

        $setLastpage = ceil($total/$per_page);

        $lpm1 = $setLastpage - 1;

        

        $setPaginate = "";

        if($setLastpage > 1)

        {   

            $setPaginate .= "<ul class='setPaginate'>";

                    $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";

            if ($setLastpage < 7 + ($adjacents * 2))

            {   

                for ($counter = 1; $counter <= $setLastpage; $counter++)

                {

                    if ($counter == $page)

                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                    else

                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                }

            }

            elseif($setLastpage > 5 + ($adjacents * 2))

            {

                if($page < 1 + ($adjacents * 2))        

                {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>...</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>..</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                else

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                }

            }

            

            if ($page < $counter - 1){ 

                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";

                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";

            }else{

                $setPaginate.= "<li><a class='current_page'>Next</a></li>";

                $setPaginate.= "<li><a class='current_page'>Last</a></li>";

            }



            $setPaginate.= "</ul>\n";       

        }


        return $setPaginate;

    }

    function displayPaginationBelowUserDetails($per_page,$page, $hotel_id){

        $page_url="?";
        $date1 = CURR_DATE1;
        $query = "SELECT COUNT(*) as totalCount FROM admin_login";

        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);

        $total = $rec['totalCount'];

        $adjacents = "2"; 



        $page = ($page == 0 ? 1 : $page);  

        $start = ($page - 1) * $per_page;                               

        

        $prev = $page - 1;                          

        $next = $page + 1;

        $setLastpage = ceil($total/$per_page);

        $lpm1 = $setLastpage - 1;

        

        $setPaginate = "";

        if($setLastpage > 1)

        {   

            $setPaginate .= "<ul class='setPaginate'>";

                    $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";

            if ($setLastpage < 7 + ($adjacents * 2))

            {   

                for ($counter = 1; $counter <= $setLastpage; $counter++)

                {

                    if ($counter == $page)

                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                    else

                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                }

            }

            elseif($setLastpage > 5 + ($adjacents * 2))

            {

                if($page < 1 + ($adjacents * 2))        

                {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>...</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>..</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                else

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                }

            }

            

            if ($page < $counter - 1){ 

                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";

                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";

            }else{

                $setPaginate.= "<li><a class='current_page'>Next</a></li>";

                $setPaginate.= "<li><a class='current_page'>Last</a></li>";

            }



            $setPaginate.= "</ul>\n";       

        }


        return $setPaginate;

    }
    function displayAllInsertedHotelDetailsPagination($per_page,$page){

        $page_url="?";
        $date1 = CURR_DATE1;
        $query = "SELECT COUNT(*) as totalCount FROM hotel_details";

        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);

        $total = $rec['totalCount'];

        $adjacents = "2"; 



        $page = ($page == 0 ? 1 : $page);  

        $start = ($page - 1) * $per_page;                               

        

        $prev = $page - 1;                          

        $next = $page + 1;

        $setLastpage = ceil($total/$per_page);

        $lpm1 = $setLastpage - 1;

        

        $setPaginate = "";

        if($setLastpage > 1)

        {   

            $setPaginate .= "<ul class='setPaginate'>";

                    $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";

            if ($setLastpage < 7 + ($adjacents * 2))

            {   

                for ($counter = 1; $counter <= $setLastpage; $counter++)

                {

                    if ($counter == $page)

                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                    else

                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                }

            }

            elseif($setLastpage > 5 + ($adjacents * 2))

            {

                if($page < 1 + ($adjacents * 2))        

                {

                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>...</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                    $setPaginate.= "<li class='dot'>..</li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      

                }

                else

                {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";

                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";

                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++)

                    {

                        if ($counter == $page)

                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";

                        else

                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  

                    }

                }

            }

            

            if ($page < $counter - 1){ 

                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";

                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";

            }else{

                $setPaginate.= "<li><a class='current_page'>Next</a></li>";

                $setPaginate.= "<li><a class='current_page'>Last</a></li>";

            }



            $setPaginate.= "</ul>\n";       

        }


        return $setPaginate;

    }

    function displayPaginationOfActiveHotelDetails($per_page,$page){
        $page_url="?";
        $date1 = CURR_DATE1;
        $query = "SELECT COUNT(*) as totalCount FROM hotels WHERE status = 0";
        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);
        $total = $rec['totalCount'];
        $adjacents = "2"; 
        $page = ($page == 0 ? 1 : $page);  
        $start = ($page - 1) * $per_page;                               
        $prev = $page - 1;                          
        $next = $page + 1;
        $setLastpage = ceil($total/$per_page);
        $lpm1 = $setLastpage - 1;
        
        $setPaginate = "";
        if($setLastpage > 1){   
            $setPaginate .= "<ul class='setPaginate'>";
                $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
            if ($setLastpage < 7 + ($adjacents * 2)){   
                for ($counter = 1; $counter <= $setLastpage; $counter++){
                    if ($counter == $page)
                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                    else
                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                }
            } elseif($setLastpage > 5 + ($adjacents * 2)) {
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }
                    $setPaginate.= "<li class='dot'>...</li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>"; 

                } elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }

                    $setPaginate.= "<li class='dot'>..</li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      
                }else{

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++) {

                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }
                }
            }

            if ($page < $counter - 1){ 
                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";
                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";
            }else{
                $setPaginate.= "<li><a class='current_page'>Next</a></li>";
                $setPaginate.= "<li><a class='current_page'>Last</a></li>";
            }
            $setPaginate.= "</ul>\n";       
        }
        return $setPaginate;
    }
    function displayPaginationOfInactiveHotelDetails($per_page,$page){
        $page_url="?";
        $date1 = CURR_DATE1;
        $query = "SELECT COUNT(*) as totalCount FROM hotels WHERE status = 1";
        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);
        $total = $rec['totalCount'];
        $adjacents = "2"; 
        $page = ($page == 0 ? 1 : $page);  
        $start = ($page - 1) * $per_page;                               
        $prev = $page - 1;                          
        $next = $page + 1;
        $setLastpage = ceil($total/$per_page);
        $lpm1 = $setLastpage - 1;
        
        $setPaginate = "";
        if($setLastpage > 1){   
            $setPaginate .= "<ul class='setPaginate'>";
                $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
            if ($setLastpage < 7 + ($adjacents * 2)){   
                for ($counter = 1; $counter <= $setLastpage; $counter++){
                    if ($counter == $page)
                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                    else
                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                }
            } elseif($setLastpage > 5 + ($adjacents * 2)) {
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }
                    $setPaginate.= "<li class='dot'>...</li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>"; 

                } elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }

                    $setPaginate.= "<li class='dot'>..</li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      
                }else{

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++) {

                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }
                }
            }

            if ($page < $counter - 1){ 
                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";
                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";
            }else{
                $setPaginate.= "<li><a class='current_page'>Next</a></li>";
                $setPaginate.= "<li><a class='current_page'>Last</a></li>";
            }
            $setPaginate.= "</ul>\n";       
        }
        return $setPaginate;
    }

    function displayPaginationOfInvoiceDetails($per_page,$page,$hotel_id){
        $page_url="?";
        $date1 = CURR_DATE1;
        $query = "SELECT COUNT(*) as totalCount FROM invoice_details WHERE status = 0 AND hotel_id = '$hotel_id'";
        $exe_query = $this->db->execute($query);
        $rec = $this->db->getResult($exe_query);
        $total = $rec['totalCount'];
        $adjacents = "2"; 
        $page = ($page == 0 ? 1 : $page);  
        $start = ($page - 1) * $per_page;                               
        $prev = $page - 1;                          
        $next = $page + 1;
        $setLastpage = ceil($total/$per_page);
        $lpm1 = $setLastpage - 1;
        
        $setPaginate = "";
        if($setLastpage > 1){   
            $setPaginate .= "<ul class='setPaginate'>";
                $setPaginate .= "<li class='setPage'>Page $page of $setLastpage</li>";
            if ($setLastpage < 7 + ($adjacents * 2)){   
                for ($counter = 1; $counter <= $setLastpage; $counter++){
                    if ($counter == $page)
                        $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                    else
                        $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                }
            } elseif($setLastpage > 5 + ($adjacents * 2)) {
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }
                    $setPaginate.= "<li class='dot'>...</li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>"; 

                } elseif($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                    $setPaginate.= "<li class='dot'>...</li>";

                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }

                    $setPaginate.= "<li class='dot'>..</li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>$setLastpage</a></li>";      
                }else{

                    $setPaginate.= "<li><a href='{$page_url}page=1'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2'>2</a></li>";
                    $setPaginate.= "<li class='dot'>..</li>";

                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++) {

                        if ($counter == $page)
                            $setPaginate.= "<li><a class='current_page'>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter'>$counter</a></li>";                  
                    }
                }
            }

            if ($page < $counter - 1){ 
                $setPaginate.= "<li><a href='{$page_url}page=$next'>Next</a></li>";
                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage'>Last</a></li>";
            }else{
                $setPaginate.= "<li><a class='current_page'>Next</a></li>";
                $setPaginate.= "<li><a class='current_page'>Last</a></li>";
            }
            $setPaginate.= "</ul>\n";       
        }
        return $setPaginate;
    }
}
    

?>