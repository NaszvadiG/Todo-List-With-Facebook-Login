$body = $("body");

    $(document).on({
        ajaxStart: function() { $body.addClass("loading");    },
         ajaxStop: function() { $body.removeClass("loading"); }    
    });
    // Create a "close" button and append it to each list item
    function countItemLeft(){
      var itemLeftCount = $('li.todo_item').length;
      
      $('li.todo_item').each(function(){
        if($(this).hasClass('checked')){
          itemLeftCount--;
        }
      });
      $('#itemsLeft').text(itemLeftCount);      
    }

    $(document).ready(function(){
      $('#err_msg').hide();
      countItemLeft();
      $('li.todo_item').each(function(){
        $(this).append("<span class='close'>\u00D7</span>");
      });
    });

    $('#todo_task_name').keydown(function(e){
      var textVal = $('#todo_task_name').val();
      var charLenght = textVal.length;
      var patt = new RegExp("^[a-zA-Z 0-9\_\-]*$");
      var res = patt.test(textVal);
      if(!res) return false;
      if((charLenght+1) > 100){
          $('#err_msg').text('Task name should not exceed 100 characters!').show();
      }
      else{
        $('#err_msg').text('').hide();
      }
    });
    // Click on a close button to hide the current list item
    $('#myUL').on('click','span.close', function(e){
      $('#err_msg').hide();
        var listItem = $(this).closest('li');
        $.post(base_url+"dashboard/updateTodoItem", {todo_task_id: $(listItem).find('input.checkboxItemCheck').attr('id'),todo_task_deleted:'yes'}, function(result){
            var resObj = JSON.parse(result);
            if(resObj.result == 'success'){
              $(listItem).remove();
              countItemLeft();
            } else {
                $('#err_msg').text(resObj.msg).show();
            } 
        });
    });

    // Add a "checked" symbol when clicking on a list item
    $('#myUL').on('click','input.checkboxItemCheck',function(){
      $('#err_msg').hide();
      var checkedChangeToStatus = 'no';
      if($(this).is(':checked')){
        checkedChangeToStatus = 'yes';
      } else {
        checkedChangeToStatus = 'no'; 
      }
      var thisEl = $(this).closest('li');
      $.post(base_url+"dashboard/updateTodoItem", {todo_task_id: $(this).attr('id'),todo_task_completed:checkedChangeToStatus}, function(result){
          var resObj = JSON.parse(result);
          if(resObj.result == 'success'){
            $(thisEl).toggleClass('checked');
            countItemLeft();
          } else {
            $('#err_msg').text(resObj.msg).show();
          } 
      });
    });

    function newElement() {
      $('#err_msg').hide();
      var inputValue = $('#todo_task_name').val();
      var patt = new RegExp("^[a-zA-Z 0-9\_\-]*$");
      var res = patt.test(inputValue);
      if (inputValue === '' || !res) {
        $('#err_msg').text('Please enter a valid task name!').show();
      } else {
        $.post(base_url+"dashboard/addTodoList", {todo_task_name: inputValue}, function(result){
            var resObj = JSON.parse(result);
            if(resObj.result == 'success'){
                var liEl = '<li class="todo_item">'
                  + '<div class="row">'
                    + '<div class="col-sm-2 col-xs-2 text-left">'
                    + '<div class="squaredThree">'
                    + '<input type="checkbox" class="checkboxItemCheck" name="checkedItems" id="'+resObj.todo_task_id+'" >'
                    + '<label for="'+resObj.todo_task_id+'"></label>'
                    + '</div>'
                    + '</div>'
                    + '<div class="col-sm-10 col-xs-10 task_name text-left">'
                    + inputValue
                    + '</div>'
                  + '</div>'
                  + "<span class='close'>\u00D7</span>"
                  + '</li>';
                $("#myUL").prepend(liEl);
                $('#todo_task_name').val('');
                countItemLeft();
            } else {
              $('#err_msg').text(resObj.msg).show();
            } 
        });
      }
    }

    function charNumOnly() {
        /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || $(".charNumOnly").keydown(function(e) {
          -1 !== $.inArray(e.keyCode, [46, 8, 9, 27, 13, 110,173,109,189,32]) || 65 == e.keyCode && e.ctrlKey === !0 || e.keyCode >= 35 && e.keyCode <= 39 || (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) && (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 65 || e.keyCode > 90) && e.preventDefault()
        })
    }
    charNumOnly();