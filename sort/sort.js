// const collapseElementList = document.querySelectorAll('.collapse')
// const collapseList = [...collapseElementList].map(collapseEl => new bootstrap.Collapse(collapseEl))
$(document).ready(function() {
    $('.section-title').click(function(e) {
        // Get current link value
        var currentLink = $(this).attr('href');
        if($(e.target).is('.active')) {
            close_section();
        }else {
            close_section();
        // Add active class to section title
        $(this).addClass('active');
        // Display the hidden content
        $('.accordion ' + currentLink).slideDown(350).addClass('open');
        }
    e.preventDefault();
    });
        
    function close_section() {
        $('.accordion .section-title').removeClass('active');
        $('.accordion .section-content').removeClass('open').slideUp(350);
    }
        
    });