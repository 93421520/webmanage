<?php
namespace Core;

use Jenssegers\Blade\Blade;
use Exception;

/**
 * 核心视图渲染类 - 封装 Blade 引擎
 */
class View {
    private static $blade = null;

    /**
     * 初始化 Blade 引擎
     * * @param string|array $templatePath 模板文件存放路径
     * @param string $cachePath 编译缓存路径
     */
    public static function init($templatePath, $cachePath) {
        if (!is_dir($cachePath)) {
            if (!mkdir($cachePath, 0777, true)) {
                throw new Exception("无法创建模板缓存目录: {$cachePath}");
            }
        }
        self::$blade = new Blade($templatePath, $cachePath);
    }

    /**
     * 渲染模板并返回 HTML 内容
     * * @param string $template 模板名称 (例如 'admin.login')
     * @param array $data 传递给模板的变量
     * @return string
     */
    // core_system/src/View.php

        public static function make($template, $data = []) {
            if (self::$blade === null) {
                // 核心视图目录：指向 core_system/views
                $coreViewPath = dirname(__DIR__) . '/views'; 
                
                // 客户私有视图目录
                $clientViewPath = DATA_PATH . '/templates';
                
                $viewPaths = [$clientViewPath, $coreViewPath];
                
                // 缓存目录 (确保 DATA_PATH 下有这个文件夹，且有写入权限)
                $cachePath = DATA_PATH . '/cache/views';
                
                self::init($viewPaths, $cachePath);
            }
            return self::$blade->make($template, $data)->render();
        }
}