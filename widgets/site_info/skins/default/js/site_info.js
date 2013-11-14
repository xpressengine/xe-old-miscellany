function doSiteSignUp() {
    exec_xml('member','procMemberSiteSignUp', new Array(), function() { location.reload(); } );
}

function doSiteLeave(leave_msg) {
    if(!confirm(leave_msg)) return;
    exec_xml('member','procMemberSiteLeave', new Array(), function() { location.reload(); } );
}
