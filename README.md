Forked from https://github/phacility/phabricator.git to provide RPM packaging
for RHEL/Centos 6.

Howto build:
* yum install rpm-build git
* git clone https://github/vinzent/phabricator.git
* cd phabricator
* rpmbuild -bb resources/rhel/phabricator.spec

3 RPM's are built:
* phabricator: webapps
* phabricator-arcanist: "arc" tool
* phabricator-libphutil: libphutil php lib

Install:
* yum localinstall ~/rpmbuild/RPMS/noarch/phabricator-*.rpm
* /opt/phacility/phabricator/bin/config set mysql.user dbuser
* /opt/phacility/phabricator/bin/config set mysql.pass dbpass
* /opt/phacility/phabricator/bin/storage upgrade
* service phabricator start
* cp resources/rhel/phabricator.httpd.conf /etc/httpd/conf.d/phabricator.conf
* service httpd restart

Upgrade:
* service httpd stop
* service phabricator stop
* yum localinstall ~/rpmbuild/RPMS/noarch/phabricator-*.rpm
* /opt/phacility/phabricator/bin/storage upgrade
* service phabricator start
* service httpd start

Original README:

**Phabricator** is an open source collection of web applications which help software companies build better software.

Phabricator includes applications for:

  - reviewing and auditing source code;
  - hosting and browsing repositories;
  - tracking bugs;
  - managing projects;
  - conversing with team members;
  - assembling a party to venture forth;
  - writing stuff down and reading it later;
  - hiding stuff from coworkers; and
  - also some other things.

You can learn more about the project (and find links to documentation and resources) at [Phabricator.org](http://phabricator.org)

Phabricator is developed and maintained by [Phacility](http://phacility.com).

----------

**BUG REPORTS**

Please update your install to **HEAD** before filing bug reports. Follow our [bug reporting guide](https://secure.phabricator.com/book/phabcontrib/article/bug_reports/) for complete instructions.

**FEATURE REQUESTS**

We're big fans of feature requests that state core problems, not just 'add this'. We've compiled a short guide to effective upstream requests [here](https://secure.phabricator.com/book/phabcontrib/article/feature_requests/).

**COMMUNITY CHAT**

Please visit our [IRC Channel (#phabricator on FreeNode)](irc://chat.freenode.net/phabricator) to talk with other members of the Phabricator community. There might be someone there who can help you with setup issues or what image to choose for a macro.

**SECURITY ISSUES**

Phabricator participates in HackerOne and may pay out for various issues reported there. You can find out more information on our [HackerOne page](https://hackerone.com/phabricator).

**PULL REQUESTS**

We do not accept pull requests through GitHub. If you would like to contribute code, please read our [Contributor's Guide](https://secure.phabricator.com/book/phabcontrib/article/contributing_code/) for more information.

**LICENSE**

Phabricator is released under the Apache 2.0 license except as otherwise noted.