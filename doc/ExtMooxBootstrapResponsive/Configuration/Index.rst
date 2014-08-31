

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


Configuration
-------------

If you did not import some Pages you should start with a rootpage and
include the static templates in following order:

MOOX Bootstrap Responsive (moox\_core)

MOOX Main Extensions (like moox\_news)

MOOX Content Extensions (like moox\_sequence)

MOOX Template (extension\_key\_of\_template)

Now you must configure the Domain and Page Title via Constants Editor
(you should also do this on root-level). There are further constants
to configure MOOX, but these two are the only necessary configuration
options.

You may add one or two Domain Records on you Root-Page to get your
project running with and without the www-prefix.

Now select a Page Layout on Root-level and start with your content.

Have Fun!

Alternatively you may order a ready2run plattform on
`http://www.moox.org/services/hosting
<http://www.moox.org/services/hosting>`_


