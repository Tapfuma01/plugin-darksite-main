jQuery(function ($) {
  //check for cookie on document load
  $(function () {
    if (!sessionStorage.getItem('hidden')) {
      sessionStorage.setItem('hidden', false);
    }
    var hidden = sessionStorage.getItem('hidden');

    if (hidden == 'false') {
      console.log(hidden);
      document.getElementById('darksitePopUp').style.display = 'flex';
      document.getElementById('darksitePopUpReopen').style.display = 'none';
    } else {
      document.getElementById('darksitePopUpReopen').style.display = 'flex';
    }
  });

  $('#darksiteCloseBtn').click(function () {
    sessionStorage.setItem('hidden', true);
    var hidden = sessionStorage.getItem('hidden');
    if (hidden == 'true') {
      console.log(hidden);
      document.getElementById('darksitePopUp').style.display = 'none';
      document.getElementById('darksitePopUpReopen').style.display = 'flex';
    }
  });

  $('.darksite_post').click(function () {
    sessionStorage.setItem('hidden', true);
    var hidden = sessionStorage.getItem('hidden');
    if (hidden == 'true') {
      console.log(hidden);
      document.getElementById('darksitePopUp').style.display = 'none';
      document.getElementById('darksitePopUpReopen').style.display = 'flex';
    }
  });

  $('#darksitePopupReopenBtn').click(function () {
    sessionStorage.setItem('hidden', false);
    var hidden = sessionStorage.getItem('hidden');
    if (hidden == 'false') {
      document.getElementById('darksitePopUpReopen').style.display = 'none';
      document.getElementById('darksitePopUp').style.display = 'flex';
    }
  });
});

jQuery(function ($) {
  // Show the first tab and hide the rest
  $('#tabs-nav li:first-child').addClass('active');
  $('.tab-content').hide();
  $('.tab-content:first').show();

  // Click function
  $('#tabs-nav li').click(function () {
    $('#tabs-nav li').removeClass('active');
    $(this).addClass('active');
    $('.tab-content').hide();

    var activeTab = $(this).find('a').attr('href');
    $(activeTab).fadeIn();
    return false;
  });
});
