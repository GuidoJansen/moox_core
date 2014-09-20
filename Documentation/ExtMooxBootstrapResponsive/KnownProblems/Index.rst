

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Known problems
--------------

As MOOX is an auto-configuring Template Extension it changes some core
behaviors of TYPO3. MOOX should only be installed on new
TYPO3-plattforms as it is incompatible to following extensions:

- all templating Extensions like Templavoila other Boostrap-Packages
  etc.

- css\_styled\_content (must be deinstalled manually)

- all older pibase-Extensions

- most Extensions that generate own FE-Output

All magic comes with a price: you need a well performing hosting-
plattform and you really ned efficient caching. For smaller websites
we recommend using the Static File Cache (nc\_staticfilecache), for
portals consider using Varnish or Cloudfront.

MOOX is not out-of-the-box ready for multidomain setups. You may
install as much Template-Extensions on one plattform, but there are
some issues using page-templates and content-elements. As we have not
implemented automatic robots.txt for multidomains yet, you must set up
different ones on your own, if you want to include your sitemap.xml.
To publish multiple sitemaps, you must extend our TypoScript, the
realurl-config and .htaccess. This may help:
`http://www.d-mind.de/blog/blog-post/2014/04/14/sitemapxml-und-
robotstxt-in-einer-multidomain-typo3-instanz.html
<http://www.d-mind.de/blog/blog-post/2014/04/14/sitemapxml-und-
robotstxt-in-einer-multidomain-typo3-instanz.html>`_

Oops, an error eccured!
#######################

Could not analyse class:FluidTYPO3\Vhs\ViewHelpers\Variable\SetViewHelper maybe not loaded or no autoloader?
Seems you do not have compatible FluidTYPO3 Extensions installed, download our full package including FluidTYPO3 from https://sourceforge.net/projects/moox-typo3-bootstrap/files/ 

Uncaught TYPO3 Exception
########################

#1402663428: No page template selected and no template was inherited from parent page(s) (More information)
Include the static template and choose a page layout in your ROOT-pages properties.

Site looks weird
################

The site appears, but looks a bit weird (e.g. no images, if you made an image content element) and there is a "Hello World".
Configure your moox-domain and delete the following lines from your ROOT-pages TypoScript-Template (Choose Info/Edit and then edit your Setup):
# Default PAGE object:
page = PAGE
page.10 = TEXT
page.10.value = HELLO WORLD!
and configure your MOOX-Domain in constants-editor like described above.

Drag n Drop BE Problem
######################

Cannot move content elements with drag n drop but there are up/down buttons, howto enable?
Go to your user properties in TYPO3 BE, click the edit and advanced functions tab and reset your configuration there.

Other Problem?
##############

Please refer to the MOOX Github Repository and check the issues for
more information:

`https://github.com/dcngmbh/moox\_core/issues
<https://github.com/dcngmbh/moox_core/issues>`_ and check the next
chapter To-do-list.


