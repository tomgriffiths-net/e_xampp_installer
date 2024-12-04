<?php
//Your Variables go here: $GLOBALS['EXEC__xampp_installer']['YourVariableName'] = YourVariableValue
class e_xampp_installer{
    //public static function command($line):void{}//Run when base command is class name, $line is anything after base command (string). e.g. > [base command] [$line]
    public static function install(array $disabled = array(),$createApacheServer = false,$silent = true){
        if(!is_file("C:\\xampp\\uninstall.exe") || $silent === false){
            //$installFile = $GLOBALS['e_xampp_installer']['paths']['install.exe'];
            $modules = array(
                "xampp_apache",
                "xampp_mysql",
                "xampp_filezilla",
                "xampp_mercury",
                "xampp_tomcat",
                "xampp_php",
                "xampp_perl",
                "xampp_phpmyadmin",
                "xampp_webalizer",
                "xampp_sendmail"
            );
            $installerPath = "C:\\xamppinstaller\\xampp-windows-x64-8.2.12-0-VS16-installer.exe";
            if(!is_file($installerPath)){
                downloader::downloadFile("https://altushost-swe.dl.sourceforge.net/project/xampp/XAMPP%20Windows/8.2.12/xampp-windows-x64-8.2.12-0-VS16-installer.exe",$installerPath);
            }
            mklog("general","Installing the XAMPP constrol panel and its components",false);
            if($silent){
                exec($installerPath . " --mode unattended");
            }
            else{
                exec($installerPath);
            }
            if(is_file("C:\\xampp\\uninstall.exe")){
                unlink($installerPath);
                mklog("general","XAMPP control panel installed",false);
                if(!is_admin::check()){
                    mklog("general","Please run the XAMPP control panel as administrator to avoid permmission issues",false);
                }
                if(class_exists('apache') && $createApacheServer){
                    mklog('general','Creating apache server',false);
                    $serverNumber = apache::new_server("C:\\xampp\\apache\\bin\\httpd.exe",getcwd() . "/apache/server<serverNumber>","Default XAMPP Apache Server");
                    mklog('general','Default xampp apache server has an id of ' . $serverNumber,false);
                    mklog('general','Starting apache server ' . $serverNumber,false);
                    apache::start($serverNumber);
                }
            }
            else{
                mklog("warning","Failed to complete XAMPP control panel installation",false);
            }
        }
        else{
            mklog("general","XAMPP control panel is allready installed",false);
        }
        
    }

    //public static function init():void{
        
    //}//Run at startup

    /*
    XAMPP 8.2.12-0
    Usage:

    --help                                              Display the list of valid options

    --version                                           Display product information

    --unattendedmodeui <unattendedmodeui>               Unattended Mode UI
                                                        Default: none
                                                        Allowed: none minimal minimalWithDialogs

    --optionfile <optionfile>                           Installation option file
                                                        Default: 

    --debuglevel <debuglevel>                           Debug information level of verbosity
                                                        Default: 2
                                                        Allowed: 0 1 2 3 4

    --mode <mode>                                       Installation mode
                                                        Default: win32
                                                        Allowed: win32 unattended

    --debugtrace <debugtrace>                           Debug filename
                                                        Default: 

    --enable-components <enable-components>             Comma-separated list of components
                                                        Default: xampp_server,xampp_apache,xampp_mysql,xampp_filezilla,xampp_mercury,xampp_tomcat,xampp_program_languages,xampp_php,xampp_perl,xampp_tools,xampp_phpmyadmin,xampp_webalizer,xampp_sendmail
                                                        Allowed: xampp_mysql xampp_filezilla xampp_mercury xampp_tomcat xampp_perl xampp_phpmyadmin xampp_webalizer xampp_sendmail

    --disable-components <disable-components>           Comma-separated list of components
                                                        Default: 
                                                        Allowed: xampp_mysql xampp_filezilla xampp_mercury xampp_tomcat xampp_perl xampp_phpmyadmin xampp_webalizer xampp_sendmail

    --installer-language <installer-language>           Language selection
                                                        Default: en
                                                        Allowed: sq ar es_AR az eu pt_BR bg ca hr cs da nl en et fi fr de el he hu id it ja kk ko lv lt no fa pl pt ro ru sr zh_CN sk sl es sv th zh_TW tr tk uk va vi cy

    --prefix <prefix>                                   Select a folder
                                                        Default: 

    --xampp_control_language <xampp_control_language>   Language
                                                        Default: English
                                                        Allowed: en de


    */
}