    <?php
        $columnName = $_SESSION['column'];
        $sort = $_SESSION['sort'];
        $type = $_SESSION['type'];
    ?>    
    <ul class="pagination">
        <?php
        if($columnName !='' && $sort !=''){
            if($type == 'search'){
                $this->Paginator->options['url'] = array('controller' => 'resourcecourse', 'action' => 'search',$strKeywordSearch,"?Sort=".($sort)."&Column=".($columnName).""); 
            }else if($type == 'draftedsearch'){
                $this->Paginator->options['url'] = array('controller' => 'resourcecourse', 'action' => 'draftedsearch',$strKeywordSearch,"?Sort=".($sort)."&Column=".($columnName).""); 
            }else if($type == 'moderatedsearch'){
                $this->Paginator->options['url'] = array('controller' => 'resourcecourse', 'action' => 'moderatedsearch',$strKeywordSearch,"?Sort=".($sort)."&Column=".($columnName).""); 
            }else{
                $this->Paginator->options['url'] = array('controller' => 'resourcecourse', 'action' => 'index',"?Sort=".($sort)."&Column=".($columnName).""); 
            }
           
        }
        echo $this->Paginator->prev(__('prev'), array('tag' => 'li'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
        echo $this->Paginator->numbers(array('separator' => '', 'currentTag' => 'a', 'currentClass' => 'active', 'tag' => 'li', 'first' => 1));
        echo $this->Paginator->next(__('next'), array('tag' => 'li', 'currentClass' => 'disabled'), null, array('tag' => 'li', 'class' => 'disabled', 'disabledTag' => 'a'));
        ?>
    </ul>