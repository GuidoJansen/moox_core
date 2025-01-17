mod.wizards.newContentElement >
mod.wizards.newContentElement {
    renderMode = tabs
    wizardItems {
        common.header = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common
        common.elements {

            header {
                iconIdentifier = content-header
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_headerOnly_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_headerOnly_description
                tt_content_defValues {
                    CType = header
                }
            }


            text {
                iconIdentifier = content-text
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_regularText_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_regularText_description
                tt_content_defValues {
                    CType = text
                }
            }

            textpic {
                iconIdentifier = content-textpic
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_textImage_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_textImage_description
                tt_content_defValues {
                    CType = textpic
                }
            }

            media {
                iconIdentifier = content-textpic
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_textMedia_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_textMedia_description
                tt_content_defValues {
                    CType = media
                }
            }

            image {
                iconIdentifier = content-image
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_imagesOnly_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_imagesOnly_description
                tt_content_defValues {
                    CType = image
                }
            }

            bullets {
                iconIdentifier = content-bullets
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_bulletList_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_bulletList_description
                tt_content_defValues {
                    CType = bullets
                }
            }

            table {
                iconIdentifier = content-table
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_table_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:common_table_description
                tt_content_defValues {
                    CType = table
                }
            }
        }

        common.show := addToList(header,text,textpic,media,image,bullets,table)

        special.header = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special
        special.elements {

            uploads {
                iconIdentifier = content-special-uploads
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_filelinks_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_filelinks_description
                tt_content_defValues {
                    CType = uploads
                }
            }

            menu {
                iconIdentifier = content-special-menu
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_menus_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_menus_description
                tt_content_defValues {
                    CType = menu
                    menu_type = 0
                }
            }

            html {
                iconIdentifier = content-special-html
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_plainHTML_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_plainHTML_description
                tt_content_defValues {
                    CType = html
                }
            }

            div {
                iconIdentifier = content-special-div
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_divider_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_divider_description
                tt_content_defValues {
                    CType = div
                }
            }

            shortcut {
                iconIdentifier = content-special-shortcut
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_shortcut_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:special_shortcut_description
                tt_content_defValues {
                    CType = shortcut
                }
            }
        }

        special.show := addToList(uploads,menu,html,div,shortcut)

		# dummy placeholder for forms group
        forms.header = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:forms

        plugins.header = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:plugins
        plugins.elements {
            general {
                iconIdentifier = content-plugin
                title = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:plugins_general_title
                description = LLL:EXT:backend/Resources/Private/Language/locallang_db_new_content_el.xlf:plugins_general_description
                tt_content_defValues.CType = list
            }
        }

        plugins.show := addToList(*)
    }
}