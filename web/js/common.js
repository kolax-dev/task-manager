

function saveEdit(){
$('.save-edit').on('click', function(){
  var id = $(this).data('id');
  var msg =$('#form-task-'+id).serialize();

        $.ajax({
          url: "/site/edit-task",
          dataType: "json",
          type:"POST",
          data: msg,
          success: function(data) {
            if(data.mess) {
              alert(data.mess);
            } else {
              $('#task-'+id).find('.name-task').html(data.model.name);
              $('#task-'+id).find('.check').html(data.deadline);
              $('#task-'+id).removeClass().addClass('task '+data.color);
              $('.close').trigger('click');
            }
          },
          error: function () {
            alert('Что-то пошло не так !');
          }
        });
});
}
function delTask() {
$('.del-task').on('click', function(){
  var id = $(this).data('id');
  var csrfToken = yii.getCsrfToken();
        $.ajax({
          url: "/site/del-task",
          dataType: "json",
          type:"POST",
          data: {id : id, _csrf : csrfToken},
          success: function(data) {
             $('#task-'+id).remove();
          },
          error: function () {
            alert('Что-то пошло не так !');
          }
        });
});
}

// $('.date').datepicker({
//         maxDate: null,
//         autoClose: true,
//         onSelect: function (formattedDate, date1, inst){
//             var date3 = Date.parse(date1)/1000;
//             $('.date')[0].dataset.time=date3;
//         }
//     });
