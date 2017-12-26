function frmRegFrontEnd(){

    /**
     * Toggle the slide-in login form
     *
     * @since 2.0
     */
    function showLoginForm() {
        var $formDiv = jQuery( this ).closest( '.frm_login_form' );
        var $formElement = $formDiv.find( 'form' );
        $formElement.toggle( 400, 'linear' );
        return false;
    }

    return{
        init: function(){
            jQuery(document).on('click', '.frm_login_form .frm-open-login a', showLoginForm );

        }
    };
}

var frmRegFrontEndJS = frmRegFrontEnd();
jQuery(document).ready(function($){
    frmRegFrontEndJS.init();
});