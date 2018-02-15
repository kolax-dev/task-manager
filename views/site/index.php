<?php
use app\models\Tasks;
/* @var $this yii\web\View */

$this->title = 'My Projects & Tasks';
?>
<div class="container">
  <div class="row">
    <div class="col-sm-12">
      <h2>TODO LIST by <?=$username?></h2>
      <?php if($projects) { ?>
        <?php foreach ($projects as $project) { ?>
      <div class="home" id="item-<?=$project->id?>">
          <div class="title">
              <span class="glyphicon glyphicon-list-alt icon-list"></span>
              <span class="name-proj"><?=$project->name?></span>
              <span class="edit-but">
                <span data-toggle="modal" data-target="#modal-pro<?=$project->id?>" class="glyphicon glyphicon-pencil edit-proj"></span>
                <span class="glyphicon glyphicon-trash del-proj" data-id="<?=$project->id?>" ></span>
              </span>
          </div>

          <!-- Modal for edit-project -->
              <div class="modal fade" id="modal-pro<?=$project->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form id="form-proj-<?=$project->id?>">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                          <h4 class="modal-title" id="myModalLabel">Edit Project</h4>
                        </div>
                        <div class="modal-body">
                          <label class="" >Name Project</label>
                          <input type="text" class="form-control" name="name_project" value="<?=$project->name?>" >
                          <input type="hidden" name="id_project"  value="<?=$project->id?>">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                          <button type="button" class="btn btn-primary save-proj" data-id="<?=$project->id?>">Save</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
          <!--  end modal-->

          <div class="form">
            <form class="form-horizontal">
              <div class="form-group">
                <label for="inputtask_<?=$project->id?>" class="label-plus"><span class="glyphicon glyphicon-plus-sign " style="font-size: 18px;"></span></label>
                <input type="text" class="form-control add-input" id="inputtask-<?=$project->id?>" placeholder="Start typing here">
                <button type="button" class="btn btn-success add-task" data-id="<?=$project->id?>">Add Task</button>
              </div>
            </form>
          </div>
          <?php if($project->getTasks($project->id)){ ?>
            <?php foreach($project->getTasks($project->id) as $task) { ?>
                <div class="task <?=Tasks::getColor($task['status'])?>" id="task-<?=$task['id']?>">
                  <div class="row">
                    <div class="col-sm-2 col-xs-4 check"><?=(!empty($task['deadline'])) ? Yii::$app->formatter->asDatetime($task['deadline'], "php:d.m.Y") : 'deadline not set';?></div>
                    <div class="col-sm-8 col-xs-5 name-task"><?=$task['name']?></div>
                    <div class="col-sm-2 col-xs-3 option-task">
                      <button  data-toggle="modal" data-target="#modal<?=$task['id']?>">
                        <span class="glyphicon glyphicon-pencil"></span>
                      </button>
                      <button class="del-task" type="button" data-id="<?=$task['id']?>">
                        <span class="glyphicon glyphicon-trash"></span>
                      </button>
                            <!-- Modal for task -->
                                <div class="modal fade" id="modal<?=$task['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <form id="form-task-<?=$task['id']?>">
                                          <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Edit task</h4>
                                          </div>
                                          <div class="modal-body">
                                            <label class="" >Name Task</label>
                                            <input type="text" class="form-control" name="name_task" value="<?=$task['name']?>" >
                                            <label class="" >Status</label>
                                            <select class="form-control" name="status_task" >
                                              <option value="none" <?=($task['status'] == 'none') ? 'selected' : '' ?>>none</option>
                                              <option value="priority" <?=($task['status'] == 'priority') ? 'selected' : '' ?>>priority</option>
                                              <option value="done" <?=($task['status'] == 'done') ? 'selected' : '' ?>>done</option>
                                            </select>
                                            <label class="" >Deadline</label>
                                            <input type="date" class="form-control date" name="deadline" value="<?=$task['deadline']?>">
                                            <input type="hidden" name="id_task"  value="<?=$task['id']?>">
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <button type="button" class="btn btn-primary save-edit" data-id="<?=$task['id']?>">Save</button>
                                          </div>
                                        </form>
                                    </div>
                                  </div>
                                </div>
                            <!--  end modal-->
                    </div>
                  </div>
                </div>
        <?php } ?>
        <?php } ?>
      </div>
    <?php } ?>
  <?php } ?>
    </div>
    <div class="col-sm-12 new-proj">
      <button data-toggle="modal" data-target="#modal-newpro" class="btn-lg btn-primary add-project" ><span class="glyphicon glyphicon-plus-sign " style="font-size: 20px;    margin-right: 10px;"></span>Add TODO List</button>
      <!-- Modal for new-project -->
          <div class="modal fade" id="modal-newpro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <form id="form-newpro">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title" id="myModalLabel">Add new Project</h4>
                    </div>
                    <div class="modal-body">
                      <label class="" >Name Project</label>
                      <input type="text" class="form-control" name="name_project" value="" >
                      <input type="hidden" name="user_id"  value="<?=Yii::$app->user->getID()?>">
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      <button type="button" class="btn btn-primary add-proj" >Add</button>
                    </div>
                </form>
              </div>
            </div>
          </div>
      <!--  end modal-->
    </div>
  </div>
</div>



<?php
$this->registerJs(<<<JS

  $('.add-proj').on('click', function(){
    var msg =$('#form-newpro').serialize();
          $.ajax({
            url: "/site/add-project",
            dataType: "json",
            type:"POST",
            data: msg,
            success: function(data) {
              if(data.mess){
                alert(data.mess);
              }else{
                $('.close').trigger('click');
                alert('Новый проект добавлен');
                document.location.reload();
             }

            },
            error: function () {
              alert('Что-то пошло не так !');
            }
          });
  });

  $('.del-proj').on('click', function(){
    var id_project = $(this).data('id');
    var csrfToken = yii.getCsrfToken();
          $.ajax({
            url: "/site/del-proj",
            dataType: "json",
            type:"POST",
            data: {id_project : id_project, _csrf : csrfToken},
            success: function(data) {
               $('#item-'+id_project).remove();
            },
            error: function () {
              alert('Что-то пошло не так !');
            }
          });
  });

  $('.save-proj').on('click', function(){
    var id = $(this).data('id');
    var msg =$('#form-proj-'+id).serialize();

          $.ajax({
            url: "/site/edit-proj",
            dataType: "json",
            type:"POST",
            data: msg,
            success: function(data) {
               $('#item-'+id).find('.name-proj').html(data.model.name);
               $('.close').trigger('click');
            },
            error: function () {
              alert('Что-то пошло не так !');
            }
          });
  });

  saveEdit();
  delTask();

$('.add-task').on('click', function(){
  var id_project = $(this).data('id');
  var name_task = $('#inputtask-'+id_project).val();
  var csrfToken = yii.getCsrfToken();
        $.ajax({
          url: "/site/add-task",
          dataType: "json",
          type:"POST",
          data: {id_project : id_project, name_task : name_task, _csrf : csrfToken},
          success: function(data) {
            if(data.mess){
              alert(data.mess);
            }else{
              $('#item-'+id_project).find('.form').after('<div class="task '+data.color+'" id="task-'+data.model.id+'"><div class="row"><div class="col-sm-2 check">deadline not set</div><div class="col-sm-8 name-task">'+data.model.name+'</div><div class="col-sm-2 option-task"><button data-toggle="modal" data-target="#modal'+data.model.id+'"><span class="glyphicon glyphicon-pencil"></span></button><button class="del-task" type="button" data-id="'+data.model.id+'"><span class="glyphicon glyphicon-trash"></span></button><div class="modal fade" id="modal'+data.model.id+'" tabindex="-1" role="dialog" aria-labelledby="myModalLabel'+data.model.id+'" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><form id="form-task-'+data.model.id+'"><div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><h4 class="modal-title" id="myModalLabel'+data.model.id+'">Edit task</h4></div><div class="modal-body"><label class="">Name</label><input type="text" class="form-control" name="name_task" value="'+data.model.name+'" required=""><label class="">Status</label><select class="form-control" name="status_task"><option value="none" selected="">none</option><option value="priority">priority</option><option value="done">done</option></select><label class="" >Deadline</label><input type="date" class="form-control" name="deadline" value="'+data.model.deadline+'"><input type="hidden" name="id_task" value="'+data.model.id+'"></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button><button type="button" class="btn btn-primary save-edit" data-id="'+data.model.id+'">Save</button></div></form></div></div></div></div></div></div>');
              $('#inputtask-'+id_project).val('');
              saveEdit();
              delTask();
          }
          },
          error: function () {
            alert('Что-то пошло не так !');
          }
        });
});


JS
);
