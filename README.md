# phplus
Phplus is a web development api that helps you to create your web site easly.
You can control your header, footer vs. styles and scripts.

Api reads your codes which is created as php, html and js or whatever files and creates your web site as minified version.

**USAGE**

Firstly include main.php file in index.php and create new $api

*index.php*

      require("main.php");

      $api = new main_api(dirname(__FILE__)); 

call dirname where ever your api should work

Now you can set your default settings or your repositories for your web site before starting development

*for setting <html {...attributes}> (optional)*

    $api->setHtmlAttr("lang","en"); 

include your main body.php file that you will write your codes

    $api->setThemplate_parts("body","body.php");

set default head which is should used everytime (optional)

    $api->setHeaderThemplateParts("default-head","default-head.php");  

set default footer which is should used everytime (optional)

    $api->setFooterThemplateParts("default-footer","default-footer.php");

you can extend this api with your additional classes(optional)
first param is class name and second is file path

    $api->_extends("Functions","src/common/Functions.php");

let's start your new web site

    $api->init();

Start writing your codes. Create body.php file.
*body.php*
Setting page title property as named title or whatever you want because if you want to change your title you will use it

    $this->setHeader('title','<title>Hello World</title>');

you can call your classes with its name

    $myFunction = $this->getExtends("Functions");

    <!-- Writing html content -->

    <h2>Hello World</div>

Now run your new app and see the page code sources as minified version.
