    <div class="row head-form">คำสั่งให้ออกจากราชการ</div>
          <div class="row formSep">
          <div class="col-xs-12 col-md-3" >ประเภทคำสั่ง :</div>
          	  <div class="col-xs-12 col-md-2">
			    <?php echo text($arr_ct[$recap['CT_ID']]); ?>	
              </div>
            <div class="col-xs-12 col-md-3" >ประเภทความเคลื่อนไหว : </div>
          	  <div class="col-xs-12 col-md-2">
              		    <?php echo text($arr_mov[$recap['MOVEMENT_ID']]); ?>	
              </div>
          </div>
          <div class="row formSep">
			<div class="col-xs-12 col-md-3" >เลขที่ : </div>
			<div class="col-xs-12 col-md-2">
            <?php echo $recap['APPROVE_ORDER_NO'];?>
			</div>
                
              <div class="col-xs-12 col-md-3">ลงวันที่ : </div>
			   <div class="col-xs-12 col-md-2">
             	 <?php echo conv_date($recap['APPROVE_ORDER_DATE'],'short');?>
                
              </div>
             </div> 
             
            <div class="row formSep">   
			 <div class="col-xs-12 col-md-3 ">เรื่อง : </div>
			  <div class="col-xs-12 col-md-7">
				<?php echo text($recap['APPROVE_ORDER_TITLE']); ?>
                </div>
            </div>
             <div class="row formSep">
             <div class="col-xs-12 col-md-3 ">วันที่ออกจากราชการ : </div>
             <div class="col-xs-12 col-md-2">		
             <?php echo conv_date($recap['RETIRE_RESIGN_DATE'],'short');?>		
                </div>
                <div class="col-xs-12 col-md-3 ">อายุราชการ (ปี/เดือน) : </div>
                <span id="gov_old"></span>
                <div class="col-xs-12 col-md-2">	
                <?php echo $recap['RETIRE_CIVIL_YEAR']." ปี ".$recap['RETIRE_CIVIL_MONTH']." เดือน"; ?></div>
                <input type="hidden" name= "PER_DATE_ENTRANCE" id ="PER_DATE_ENTRANCE" value="<?php echo conv_date($recmain['PER_DATE_ENTRANCE']); ?>" >
            	</div>
              <div class="row formSep">
               <div class="col-xs-12 col-md-3 ">สถานะของการเป็นสมiาชิก กบข. : </div>
                <div class="col-xs-12 col-md-2"><?php echo $arr_gpf[$recmain['GPF_STATUS']]; ?>				</div>
              </div> 
            <div class="row formSep">   
			 <div class="col-xs-12 col-md-3 ">สิทธิการขอรับบำเหน็จบำนาญ : </div>
             <div class="col-xs-12 col-md-2">
              <?php echo $arr_reward[$recap['RETIRE_PENSION']]; ?>	
                </div>
             <div class="col-xs-12 col-md-3 ">สิทธิการขอรับบำเหน็จบำนาญตาม : </div>
             <div class="col-xs-12 col-md-2">
               <?php echo $arr_pension[$recap['RETIRE_PENSION_LAWS']]; ?>	
                </div>

            </div>
            
            <div class="row formSep">
              <div class="col-xs-12 col-md-3 "><span id="title" >เหตุแห่งการเกษียณอายุราชการ</span> : </div>
              <div class="col-xs-12 col-md-2">
                 <?php echo $arr_retirement[$recap['RETIRE_PENSION_TYPE']]; ?>	
			  </div>
              </div>