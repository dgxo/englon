let last = +new Date();

$(document).ready(function () {
   // now just using the form

   //$('#send-message').click(function () {

   // const now = +new Date();
   // if (now - last > 1000) {
   // 	// 5 seconds
   // 	last = now;

   // 	var clientmsg = $('#usermsg').val();
   // 	if (clientmsg.length !== 0 || clientmsg.trim()) {
   // 		console.log('Sending message: ' + clientmsg);
   // 		$.post('post.php', { text: clientmsg.substring(0, 1000) }); // btw filters and xss prevention are in post.php so no u cant hack me
   // 		$('#usermsg').val('');
   // 	}
   // }
   // return false;
   //});

   $('#message-box').animate({ scrollTop: $('#message-box')[0].scrollHeight }, 'normal');

   loadLog();
   setInterval(loadLog, 3000);
});

function loadLog() {
   var oldscrollHeight = $('#message-box')[0].scrollHeight; // Scroll height before the request also it spams console at login but whatever
   let update = document.getElementById('update') ?? null;
   if (update?.checked ?? true) {
      $.ajax({
         url: 'log.html',
         cache: false,
         success: function (html) {
            $('#message-box').html(html); //Insert chat log into the #chatbox div
            // Auto-scroll
            var newscrollHeight = $('#message-box')[0].scrollHeight; //Scroll height after the request
            if (newscrollHeight > oldscrollHeight) {
               $('#message-box').animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
            }
         }
      });
   }
}

// go away this is none of your business
function sendAdminRequest(action) {
   let msgcount = 1;
   if (action == 'del-msgs') {
      msgcount = prompt('How many messages to delete?');
   }

   if (action == 'logout-user') {
      let userId = prompt('Which user to logout? (id)');
      if (userId) {
         socket.emit('logoutUser', { userId });
      }
      return;
   } else {
      let adminreq = $.post('admin.php', { action, msgcount });
      setTimeout(() => {
         console.log('Sent admin action ' + action + ' and got ' + adminreq.statusText);
         loadLog();
      }, 500);
   }
}

function validateForm() {
   let value = $('#usermsg').val();
   if (value.trim() === '') {
      // if input is empty or whitespace-only
      alert('Message cannot be empty.');
      return false; // Prevent form submission
   }

   setTimeout(() => {
      $('#usermsg').val('');
      $('#fileinput').val('');
      loadLog();
   }, 150);

   return true; // Allow form submission
}

function setTyping(istyping, username) {
   if (istyping) {
      $('.typing').show();
      $('.typing-name').html(`<strong>${username}</strong> is typing...`);
   } else {
      $('.typing').hide();
      $('.typing-name').html(`n... n... nobody... is typing...?`);
   }
}
