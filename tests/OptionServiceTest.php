<?php
/**
 *  Naver Booking Delivery Routing test
 */

declare (strict_types = 1);
use PHPUnit\Framework\TestCase;

final class ProductServiceTest extends TestCase
{

    const ACCESS_TOKEN = '4175d932e639db100683724' .
        'c85ba696c665d1b10d3f4283764d169c831698ea8e742466' .
        'f829ceedf04d48ce9f5ae618043ec6a0f333a227bfff3ca32' .
        '0c0ce78bfb61e62f51b4540877be772764139cc6f28272d32' .
        'f6dd21a4c9a619df99347e046d81ec74e57ac5fdc2a61b4e1' .
        '30ff9087c4d44c5f548715f7c28d6d684039eee00b680406c1' .
        '6a993242e486e4fee5f5b14bb7f0594789a07ead0fa6207da' .
        'b882102b0d01eeb07f73e180f7ccc319a9cef49e566d0f9346' .
        '1b212638e653d4570087a32631d518588a45a30259d174bec' .
        'c0583dee7f5aca17515d58d15911e416';

    const TEST_GET_OPTIONS = 0;
    const TEST_GET_OPTION = 0;
    const TEST_GET_OPTION_CATEGORIES = 1;
    const TEST_GET_OPTION_CATEGORY_ID_BY_NAME = 1;
    const TEST_CREATE_OPTION = 0;
    const TEST_EDIT_OPTION = 0;
    const TEST_DELETE_OPTION = 0;
    const TEST_DELETE_ALL_OPTIONS = 0;

    public function testCanGetOptions(): void
    {
        if (self::TEST_GET_OPTIONS) {
            $service = new NaverOptionService(self::ACCESS_TOKEN);
            $res = $service->getOptions(16363);
            self::_outputFile('get-options.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanGetOptions()");
        }
    }

    public function testCanGetOption(): void
    {
        if (self::TEST_GET_OPTION) {
            $service = new NaverOptionService(self::ACCESS_TOKEN);
            $res = $service->getOption(16363, 146134);
            self::_outputFile('get-option.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanGetOption()");
        }
    }

    public function testCanGetOptionCategories(): void
    {
        if (self::TEST_GET_OPTION_CATEGORIES) {
            $service = new NaverOptionService(self::ACCESS_TOKEN);
            $res = $service->getOptionCategories(16363, 146134);
            self::_outputFile('get-option-categories.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanGetOptionCategories()");
        }
    }

    public function testCanGetOptionCategoryIdByName(): void
    {
        if (self::TEST_GET_OPTION_CATEGORY_ID_BY_NAME) {
            $service = new NaverOptionService(self::ACCESS_TOKEN);
            $categoryId = $service->getOptionCategoryIdByName(16363, '카테고리 미지정');
            self::_outputFile('get-option-category-id-by-name.json',
                json_encode(['카테고리 미지정' => $categoryId], JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($categoryId);
        } else {
            echo ("\nSkipping testCanGetOptionCategoryIdByName()");
        }
    }

    public function testCanCreateOption(): void
    {
        if (self::TEST_CREATE_OPTION) {
            $service = new NaverOptionService(self::ACCESS_TOKEN);
            $option = NaverOption::example();
            $res = $service->createOption(16363, $option);
            self::_outputFile('create-option-body.json',
                json_encode($option, JSON_UNESCAPED_UNICODE));
            self::_outputFile('create-option-res.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanCreateOption()");
        }
    }

    public function testCanEditOption(): void
    {
        if (self::TEST_EDIT_OPTION) {
            $service = new NaverOptionService(self::ACCESS_TOKEN);
            $option = NaverOption::example();
            $data = $option->setDesc('새로운 설명! 새로운 설명! 새로운 설명! 새로운 설명!', true);
            $res = $service->editOption(16363, 146164, $data);
            self::_outputFile('edit-option-data.json',
                json_encode($data, JSON_UNESCAPED_UNICODE));
            self::_outputFile('edit-option-res.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanEditOption()");
        }
    }

    public function testCanDeleteOption(): void
    {
        if (self::TEST_DELETE_OPTION) {
            $service = new NaverOptionService(self::ACCESS_TOKEN);
            $res = $service->deleteOption(16363, 146131);
            self::_outputFile('delete-option.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanDeleteOption()");
        }
    }

    public function testCanDeleteAllOptions(): void
    {
        if (self::TEST_DELETE_ALL_OPTIONS) {
            $service = new NaverOptionService(self::ACCESS_TOKEN);
            $res = $service->deleteAllOptions(16363);
            self::_outputFile('delete-all-options.json',
                json_encode($res, JSON_UNESCAPED_UNICODE));

            $this->expectOutputString('');
            var_dump($res);
        } else {
            echo ("\nSkipping testCanDeleteAllOptions()");
        }
    }

    private static function _outputFile($filename, $data): void
    {
        $fp = fopen(dirname(__FILE__) . "/outputs/NaverOptionService/${filename}", 'w');
        fwrite($fp, $data);
        fclose($fp);
    }

}
