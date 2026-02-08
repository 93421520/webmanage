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
    public static function make($template, $data = []) {
        if (self::$blade === null) {
            /**
             * 默认逻辑：
             * 如果是在管理后台，我们需要包含系统核心视图路径和客户私有视图路径
             */
            $coreViewPath = dirname(__DIR__) . '/views'; // 核心后台视图
            $clientViewPath = DATA_PATH . '/templates'; // 客户私有视图
            
            // Blade 支持传入路径数组，它会按顺序查找
            $viewPaths = [$clientViewPath, $coreViewPath];
            
            // 缓存路径：每个客户拥有独立的缓存文件夹，防止冲突
            $cachePath = DATA_PATH . '/cache/views';
            
            self::init($viewPaths, $cachePath);
        }

        return self::$blade->make($template, $data)->render();
    }
}