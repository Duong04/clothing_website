
function changeTab(tabIndex) {
  document.querySelectorAll('.tab-content').forEach(function (content) {
    content.classList.remove('active');
  });

  document.getElementById(`tabContent${tabIndex}`).classList.add('active');


  document.querySelectorAll('.tab').forEach(function (tab) {
    tab.classList.remove('active');
  });


  document.querySelector(`.tab:nth-child(${tabIndex + 1})`).classList.add('active');
}

