<?php 
namespace app\core;
class Pagination
{
    public $numPerPage;
    public $limit_pages;
    public $page;
    public $request;
    /**
     * Summary of __construct
     */
    public function __construct()
    {
        $this->numPerPage =50;
        $this->limit_pages =3;
        $this->page =((isset($_GET['page']) && intval($_GET['page']) != 0)?$_GET['page']:1);
        $this->request =Application::$app->request;
    }
    /**
     * Summary of drawPager
     * @param mixed $totalItems
     * @return string
     */
    public function drawPager($totalItems){
        $body=$this->request->getBody();
        $urls='';
        foreach( $body as $k=>$v){
            if('page'!=$k)
                $urls .='&'.$k.'='.$v;
        }
        #
        $pager='';
        #
		$pages = ceil($totalItems / $this-> numPerPage);
        #
		if(!isset($this->page) || intval($this->page) == 0) {
			$page = 1;
		} else if (intval($this->page) > $totalItems) {
			$page = $pages;
		} else {
			$page = intval($this->page);
		}
        $pager = "";
        /******  build the pagination links ******/
        // range of num links to show
        $range = 2;
        $pager .= "<ul class='pagination my-1 p-0'>";
        // if not on page 1, don't show back links
        if ($page > 1) {
            // show << link to go back to page 1
            $pager .="<li class='page-item2'> <a class='page-link2' href='?page=1".$urls."'>First</a></li> ";
            // get previous page num
            $prevpage = $page - 1;
            // show < link to go back to 1 page
            //$pager .="<li class='page-item2'> <a class='page-link2' href='?page=$prevpage'>Prev</a></li> ";
        } // end if 
        if($pages >1)
        {
            // loop to show links to range of pages around current page
            for ($x = ($page - $range); $x < (($page + $range) + 1); $x++) {
                // if it's a valid page number...
                if (($x > 0) && ($x <= $pages)) {
                    // if we're on current page...
                    if ($x == $page) {
                        // 'highlight' it but don't make a link
                        $pager .=" <li class='page-item2 active'><a class='page-link2 ' href='?page=$x$urls'>$x</a></li> ";
                    // if not current page...
                    } else {
                        // make it a link
                        $pager .="<li class='page-item2'><a class='page-link2' href='?page=$x$urls'>$x</a></li>";
                    } // end else
                } // end if 
            } // end for
        }


        // if not on last page, show forward and last page links        
        if ($page != $pages && $totalItems) {
            // get next page
            $nextpage = $page + 1;
                // echo forward link for next page 
            //$pager .="<li class='page-item2'> <a class='page-link2' href='?page=$nextpage'>Next</a></li> ";
            // echo forward link for lastpage
            $pager .="<li class='page-item2'> <a class='page-link2' href='?page=$pages$urls'>Last</a></li> ";
        } // end if
        $pager .= "</ul>";
        /****** end build pagination links ******/
        return $pager;
	}
    /**
     * Summary of getLimit
     * @return string
     */
    public function getLimit(){
        $offset= ($this-> page - 1) * ($this-> numPerPage);
        $lmt=' LIMIT '.$offset.','.$this-> numPerPage;
        return $lmt;
    }
    /**
     * Summary of setNumPerPage
     * @param mixed $v
     * @return void
     */
    public function setNumPerPage($v){
        $this->numPerPage=$v;
    }
}
?>