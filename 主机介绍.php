<?php

//存储php应用有四种方式:共享服务器、虚拟私有服务器、专用服务器和平台即服务





//共享服务器 1-10美元/月
//共享服务器是最便宜的主机方案，每月1-10美元。不推荐共享服务器
/**
 * 1、主机账户与其他人共享服务器资源，使用同一个物理设备，假如使用的设备只有2GB内存，那么php应用智能占用其中的一小部分，具体使用多少要看设备有多少用户，而且很多共享主机提供商会超卖共享服务器，导致php应用始终要在拥挤的服务器中争夺资源
 * 2、共享主机很难定制，例如：可能根本无法定制Memcached或Redis服务
 * 3、很少提供SSH访问功能，通常只能使用SFTP访问，这个缺陷严重限制，妨碍了我们自动部署PHP应用
 * 注:如果预算非常少或需求简单，共享服务器也许够用了，但是如果开发的是商业网站或者比较受欢迎的PHP应用，最好使用虚拟私有服务器、专用服务器或PaaS
 */





//虚拟私有服务器 (virtual Private Server VPS) 10-100美元/月
//VPS不是逻辑服务，是由一系列系统资源组成，分布在一台或多台物理设备中，不过仍有自己的服务系统、根用户、系统进程和IP地址。VPS的内存、CPU和宽带是固定的，而且都只属于你一个人
//VPS的系统资源比共享主机多，会提供SSH，而且能安装需要的软件，可以访问底层操作系统。我们要根据php应用的需求自己手动配置和保护操作系统。对大多数PHP应用来说，VPS是最好的选择，它提供了足够的系统资源，而且能按需增减。具体多少取决于PHP应用所需的系统资源量，如果PHP访问量超过几十万访问量，觉得VPS太贵火雨应该考虑升级，使用专用服务器。
//建议：VPS在费用、功能和灵活性之间平衡。推荐使用Linode(https://linode.com)，他提供VPS和专用主机方案，主机速度快且稳定，而且有很多教程





//专用服务器 几百美元/月
//专用服务器是机架式设备，由主机上代你安装、运行和维护。我们可以根据自己定制的规格配置专用服务器。专用服务器是真是的设备，必需搬运、安装和监控，设置和配置的速度没有VPS快，但是专用服务器能为要求较高的PHP应用提供最好的性能。
//专用服务器和VPS非常类似，有根权限，会提供SSH，而且能安装需要的软件，可以访问底层操作系统。专用服务器的有点事成本效益高，当所需的系统资源越来越多，最终会觉得VPS太贵，而自己投资基础设施能省钱。我们可以托管专用服务器（额外付钱给主机上，让他们管理服务器），也可以不托管（自己管理服务器）






//PaaS
//使用平台即服务(Platforms as a Service, PaaS)
//能快速发布PHP应用，与VPS和专用服务器不同，我们无需管理PaaS。我们要做的只是登录PaaS提供商的控制面板，单机几个按钮。有些PaaS提供商会提供命令行工具或HTTP API，让我们部署和管理存储的PHP应用。流行的PHP PaaS提供商:
/**
 * 1、AppFog(https://appfog.com)
 * 2、AWS Elastic Beanstalk(http://aws.amazon.com/elasticbeanstalk)
 * 3、Engine Yard (https://www.engineyard.com/products/cloud)
 * 4、Fortrabbit(http://fortrabbit.com)
 * 5、Google App Engine (http://bit.ly/g-app-engine)
 * 6、Heroku (https://devcenter.heroku.com/categories/php)
 * 7、Microsoft Azure (http://www.windowsazure.com/)
 * 8、Pagoda Box (https://pagodabox.com)
 * 9、Red Hat OpenShift (http://openshift.com/)
 * 10、Zend Developer Cloud (http://bit.ly/z-dev-cloud)
 */
//推荐不想自己管理服务器的开发者使用PaaS主机方案



//后言:
//对于小型PHP应用或原型来说PaaS最好
//中型的 VPS
//大型的 访问量几十万几百万 用专用服务器
//不管选择哪种服务器，都要保证主机中有最新稳定版php，以及php应用所需扩展