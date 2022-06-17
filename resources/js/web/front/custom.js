update_popup();

/** EU COOKIE CONSENT - Minimal and complete message div's management */
$(document).on('click', '.gdpr-tgl-btn', function (e) {
    e.preventDefault();
    if ($(this).parent().parent().parent().hasClass('gdpr-minimal')) {
        // gdpr-minimal section hide!
        $(this).parent().parent().parent().removeClass('d-flex').removeClass('justify-content-between').addClass('d-none');
        // gdpr-detail section show!
        $(this).parent().parent().parent().next().removeClass('d-none').addClass('d-block');
    } else if ($(this).parent().parent().parent().hasClass('gdpr-detail')) {
        // gdpr-detail section hide!
        $(this).parent().parent().parent().removeClass('d-block').addClass('d-none');
        // gdpr-minimal section show!
        $(this).parent().parent().parent().prev().removeClass('d-none').addClass('d-flex').addClass('justify-content-between');
    }
});
/** EU COOKIE CONSENT - Minimal and complete message div's management ends */

/** EU COOKIE CONSENT - Before set, show full width. After set, show only the button to show full width */
$(document).on('click', '.cookie-consent-after-set-wrapper', function (e) {
    $(this).removeClass('d-block').addClass('d-none');
    $('.cookie-consent-before-set-wrapper').removeClass('d-none').find('.gdpr-tgl-btn').first().trigger('click');
});
/** EU COOKIE CONSENT - Before set, show full width. After set, show only the button to show full width ends */
