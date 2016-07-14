// default vars
var submit = false;
var stopLeft = 0;
var stopTop = 0;
var card;
var cards = new Array();
var cardNumb = new Array();
var cardSuit = new Array();
var uniqueCombos = new Array();
var drop;
var foo;

// Set Card Numbers
foo = ['j','Jack']; cardNumb[0] = foo;
foo = ['q','Queen']; cardNumb[1] = foo;
foo = ['k','King']; cardNumb[2] = foo;
foo = ['a','Ace']; cardNumb[3] = foo;

// Set Card Suits
foo = ['s','Spades']; cardSuit[0] = foo;
foo = ['c','Clubs']; cardSuit[1] = foo;
foo = ['d','Diamonds']; cardSuit[2] = foo;
foo = ['h','Hearts']; cardSuit[3] = foo;

function shuffleCards() {
  var unique = '';
  var numb;
  var suit;
  for(x=0;x<1;x++) {
    unique = '';
    numb = Math.floor(Math.random()*cardNumb.length);
    suit = Math.floor(Math.random()*cardSuit.length);
    for(n=0;n<=uniqueCombos.length;n++) { if(uniqueCombos[n] == ''+cardNumb[numb][1]+' of '+cardSuit[suit][1]+'') { unique = 'taken'; } }
    if(unique != '') { x--; } else { uniqueCombos[uniqueCombos.length] = ''+cardNumb[numb][1]+' of '+cardSuit[suit][1]+''; }
  }
  return '/assets/images-hv/hv-card-'+cardNumb[numb][0]+cardSuit[suit][0]+'.png';
}

// Generate Random Cards
function pickCards() {
  for(c=0;c<5;c++) {
    cards[c] = new Image();
    cards[c].src = shuffleCards();
  }
  drop = Math.floor(Math.random()*uniqueCombos.length);
  $('#pick').html('Drag the <strong>'+ uniqueCombos[drop] +'</strong> to the empty slot.');
}

function sendBack() {
  $('#'+card).animate({
    left: stopLeft,
    top: stopTop
  }, 500,
  function() {
    $('#hv-feedback').removeClass('feedback-fail');
    $('#hv-feedback').addClass('feedback-unknown');
    // Enable Draggables
    for(c=0;c<5;c++){ $('#hv'+c).draggable({ disabled: false }); }
  });
  $('#hv-slot-frame').css('border-color','#bbb');
}

function drawCards() {
  submit = false;
  pickCards(); // cards[c]

  // Compose Table
  for(c=0;c<5;c++) {
    $('div#cards').append('<div id="hv'+c+'"></div>');
  }

  // Set Draggables
  for(c=0;c<5;c++) {
    $('#hv'+c).css('background-image', 'url('+cards[c].src+')');

    $('#hv'+c).draggable(
    {
      containment:'#contact',
      revert:'invalid',
      revertDuration:500,
      zIndex:2222,
      start: function(event, ui)
      {
        startLeft = ui.position['left'];
        startTop = ui.position['top'];
      },
      stop: function(event, ui) { }
    });
  }
  // Disable Draggables for now
  for(c=0;c<5;c++){
    $('#c'+c).draggable({ disabled: true });
  }

  // Set Dropable
  $('#hv-slot').droppable({ tolerance: 'fit' });

  $('#hv-slot').droppable({
     over: function(event, ui) { $('#hv-slot-frame').css('border-color','#666'); }
  });

  $('#hv-slot').droppable({
     out: function(event, ui) { $('#hv-slot-frame').css('border-color','#bbb'); }
  });

  $('#hv-slot').droppable({
    drop: function(event,ui) {
      // Disable Draggables
      for(c=0;c<5;c++){
        $('#hv'+c).draggable({ disabled: true });
      }

      stopLeft = '-=' + ui.position['left'];
      stopTop = '-=' + ui.position['top'];

      // Validate Card
      if(ui.draggable.attr('id') == 'hv'+drop) { // Pass
        // Update Feedback
        $('#hv-feedback').removeClass('feedback-unknown');
        $('#hv-feedback').addClass('feedback-pass');
        $('#submit').animate({ opacity: 1 }, 300, function() { $('#submit').addClass('on'); submit = true; });
      } else { // Fail
        // Update Feedback
        $('#hv-feedback').removeClass('feedback-unknown');
        $('#hv-feedback').addClass('feedback-fail');

        // Return Card
        card = ui.draggable.attr('id');
        setTimeout('sendBack()',1500);
      }
    }
  });
}

function init_hv() {
  if($('#human-verification').css('visibility') == 'hidden') {
    uniqueCombos.length = 0;
    drawCards();

    $('#human-verification').css('opacity','0');
    $('#human-verification').css('visibility','visible');
    $('#human-verification').animate({
      opacity: 1
    }, 1500,
    function() {
      // Enable Draggables
      for(c=0;c<5;c++){
        $('#c'+c).draggable({ disabled: false });
      }
    });

  } else {
    // Disable Draggables
    for(c=0;c<5;c++){
      $('#hv'+c).draggable({ disabled: false });
    }

    $('#human-verification').animate({
      opacity: 0
    }, 500,
    function() {
      $('#human-verification').css('visibility','hidden');
      $('div#cards').html('');
      $('#hv-feedback').removeClass('feedback-unknown');
      $('#hv-feedback').removeClass('feedback-pass');
      $('#hv-feedback').removeClass('feedback-fail');
      $('#hv-feedback').addClass('feedback-unknown');
      $('#hv-slot-frame').css('border-color','#bbb');
      $('#submit').removeClass('on');
      $('#submit').addClass('off');
      $('#submit').animate({ opacity: 0.4 }, 1000);
      init_hv();
    });
  }
}


function verifyEmail(emailAddress) {
  var status = false;
  var emailRegEx = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i;
  if (emailAddress.search(emailRegEx) == -1) {
    status = false;
  } else {
    // alert("Woohoo!  The email address is in the correct format and they are the same.");
    status = true;
  }
  return status;
}


function hv_submit() {
  if(submit) {
    // window.location = "index.php";

    // Start Form Validation

    var formErrors = false;
    var fullname = $.trim($('#fullname').attr('value'));
    var emailAddy = $.trim($('#emailaddress').attr('value'));
    var message = $.trim($('#inquiry').val());

    $('#fullname').attr('value',fullname);
    $('#emailaddress').attr('value',emailAddy);
    $('#inquiry').html(message);

    // Validate Form
    if(fullname == '') {
      formErrors = true;
      $('#e1').removeClass('hidden');
    } else {
      $('#e1').addClass('hidden');
    }

    if(emailAddy == '') {
      formErrors = true;
      $('#e2').removeClass('hidden');
    } else {
      $('#e2').addClass('hidden');
      if(!verifyEmail(emailAddy)) {
        formErrors = true; $('#e2').removeClass('hidden');
      } else {
        $('#e2').addClass('hidden');
      }
    }

    if(message == '') {
      formErrors = true;
      $('#e3').removeClass('hidden');
    } else {
      $('#e3').addClass('hidden');
    }

    if(!formErrors) {

      processEmail();
      // window.location = "index.php";
    }
    // End Form Validation
  }
}


function processEmail() {
  submit = false;

  $('form#contact').animate({
    opacity: 0.3
  }, 500,
  function() {

    // Set Success Vars
    var failFullname = '';
    var failEmail = '';
    var failMessage = '';

    // Get Form Vars
    var fullname = $.trim($('#fullname').attr('value'));
    var emailAddy = $.trim($('#emailaddress').attr('value'));
    var message = $.trim($('#inquiry').val());

    // Processing
    $('div.contact-process').removeClass('hidden');

    $('div.contact-process').animate({
      opacity: 1
    }, 500,
    function() {
      $.ajax({
        url: '/assets/ajax-contact.php',
        data: 'n='+fullname+'&e='+emailAddy+'&m='+message,
        type: 'post',
        dataType: 'json',
        error: function(error) { modalMessageShow('<p>Unable to process request.<br />Please try again.</p>','contact'); },
        beforeSend: function() { /* alert("Before Send"); */ },
        complete: function() { /* alert("Complete"); */ },
        success: function(data) {
          $.each(data, function(i,items) {
            // If there was a processing error
            if(items.emailSuccess == '') { // Fail
              // Set Success Vars
              failFullname = items.fullname;
              failEmail = items.emailAddress;
              failMessage = items.inquiry;

              if(failFullname != '') {
                $('#e1').removeClass('hidden');
              }

              if(failEmail != '') {
                $('#e2').removeClass('hidden');
              }

              if(failMessage != '') {
                $('#e3').removeClass('hidden');
              }

              // If Fail, leave form fields.
              $('div.contact-process').animate({
                opacity:0
              }, 500,
              function() {
                $('div.contact-process').addClass('hidden');
                $('form#contact').animate({
                  opacity: 1
                }, 500,
                function() {
                  submit = true;
                });
              });
            } else { // Pass
              // $('div.contact-loading').addClass('hidden');

              $('div.contact-process').animate({
                opacity: 0
              }, 500,
              function() {
                $('div.contact-process').addClass('hidden');
                $('form#contact').animate({
                  opacity: 0
                }, 500,
                function() {

                  $('div.contact-success').css('opacity','0');
                  $('div.contact-success').removeClass('hidden');

                  $('div.contact-success').animate({
                    opacity: 1
                  }, 500,
                  function() {
                    // Nothing to do
                  });
                });
              });
            }
          });
        }
      });
    });
  });
}


function resetContact() {
  // Clear form fields
  $('#fullname').attr('value','');
  $('#emailaddress').attr('value','');
  $('#inquiry').attr('value','');

  // Reset Cards
  init_hv();

  // Fade form out and display success message
  $('div.contact-success').animate({
    opacity: 0
  }, 500,
  function() {
    // $('#contact-process').addClass('hidden');
    $('div.contact-success').addClass('hidden');
    $('form#contact').animate({
      opacity: 1
    }, 500,
    function() { });
  });
}

// init_hv();

$(document).ready(function() {
  init_hv();
});
