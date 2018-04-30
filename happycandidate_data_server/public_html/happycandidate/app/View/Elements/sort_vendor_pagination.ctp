    <?php
        $type = $_SESSION['vendortype'];
        if($type == 'search'){
            $columnName = $_SESSION['vendorsearchcolumn'];
            $sort = $_SESSION['vendorsearchsort'];
            
        }else{
            $columnName = $_SESSION['vendorcolumn'];
            $sort = $_SESSION['vendorsort'];
        }
    ?>    
    <ul class="pagination">
        <?php
        if($columnName !='' && $sort !=''){
            if($type == 'search'){
                $this->Paginator->options['url'] = array('controller' => 'vendorservices', 'action' => 'search',$strKeywordSearch,"?Sort=".($sort)."&Column=".($columnName).""); 
            }else{
                $this->Paginator->options['url'] = array('controller' => 'vendorservices', 'action' => 'index',"?Sort=".$sort."&Column=".($columnName).""); 
            }
           
        }
        echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
        echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
        echo $this->Paginator->next(__('next'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
        ?>
    </ul>