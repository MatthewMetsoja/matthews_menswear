<h5 class="text-center" >Please choose a month and year to view orders from </h5>
        
<div class="row">
       
                <div class="col-sm-6">
                        <h5 id="" class="text-center order_title"> <?=$this_year ?> </h5>    
                       
                        <ul class="month_order_list"> 
                                <?php 
                                for($i = 1; $i <= $this_month; $i++)
                                {
                                        $dt = DateTime::createFromFormat('!m',$i); 
                                        if($this_month == $i)
                                        { ?>
                                                <li>  
                                                        <a class="month active" href="orders.php?source=view_monthly&month=<?=$i?>&year=<?=$this_year?>"> 
                                                                <?= $dt->format("F"); ?>   
                                                        </a>  
                                                </li>  <?php
                                        }
                                        else
                                        { ?>
                                                <li> 
                                                        <a  class="month" href="orders.php?source=view_monthly&month=<?=$i?>&year=<?=$this_year?>">
                                                                <?= $dt->format("F"); ?> 
                                                        </a>   
                                                </li>  <?php 
                                        }
                        
                                } ?>
                        </ul>
                </div> 

                <div class="col-sm-6">
                        <h5 class="text-center order_title">  <?=$last_year ?> </h5>     
                
                        <ul class="month_order_list"> 
                                <?php 
                                for($i = 1; $i <= 12; $i++)
                                {
                                        $dt = DateTime::createFromFormat('!m',$i); ?>
                                        <li> 
                                                <a class="month" href="orders.php?source=view_monthly&month=<?=$i?>&year=<?=$last_year?>">
                                                        <?= $dt->format("F"); ?> 
                                                </a>   
                                        </li>   <?php 
                                }   ?>
                        </ul>
                </div>    

</div>