    <?php
        $type = $_SESSION['producttype'];
        if($type == 'search'){
            $columnName = $_SESSION['productsearchcolumn'];
            $sort = $_SESSION['productsearchsort'];
            
        }else{
            $columnName = $_SESSION['productcolumn'];
            $sort = $_SESSION['productsort'];
        }
        
        
    ?>    
    <ul class="pagination">
        <?php
        if($columnName !='' && $sort !=''){
            if($type == 'search'){
                $this->Paginator->options['url'] = array('controller' => 'resource', 'action' => 'search',$strKeywordSearch,"?Sort=".($sort)."&Column=".($columnName).""); 
            }else{
                $this->Paginator->options['url'] = array('controller' => 'resource', 'action' => 'index',"?Sort=".$sort."&Column=".($columnName).""); 
            }
           
        }
        echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
        echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
        echo $this->Paginator->next(__('next'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
        ?>
    </ul>