mod.wizards.newContentElement.wizardItems.forms {
    elements.mailform {
        icon = EXT:frontend/Resources/Public/Icons/ContentElementWizard/mailform.gif
        title = LLL:EXT:cms/layout/locallang_db_new_content_el.xlf:forms_mail_title
        description = LLL:EXT:cms/layout/locallang_db_new_content_el.xlf:forms_mail_description
        tt_content_defValues {
            CType = mailform
            bodytext (
                enctype = multipart/form-data
            method = post
            prefix = tx_form
        )
        }
    }

    show = *
}