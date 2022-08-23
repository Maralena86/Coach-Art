<?php

namespace App\DoctrineType;

abstract class OptionTypeEnum
{
    const OPTIONS_PRESENTIAL   = "presential";
    const OPTIONS_REMOTE = "remote";
   

    // /** @var array user friendly named type */
    // protected static $typeName = [
    //     self::OPTIONS_PRESENTIAL   => 'Présentiel',
    //     self::OPTIONS_REMOTE=> 'À distance',
     
    // ];

    // /**
    //  * @param  string $typeShortName
    //  * @return string
    //  */

    //  public static function getAll()
    //  {
    //      $array = [self::OPTIONS_PRESENTIAL, self::OPTIONS_REMOTE ];
         
        
    //         return $array;
        
    //  }
    // public static function getTypeName($typeShortName)
    // {
    //     if (!isset(static::$typeName[$typeShortName])) {
    //         return "Unknown type ($typeShortName)";
    //     }

    //     return static::$typeName[$typeShortName];
    // }

    // /**
    //  * @return array<string>
    //  */
    // public static function getAvailableTypes()
    // {
    //     return [
    //         self::OPTIONS_PRESENTIAL,
    //         self::OPTIONS_REMOTE,
           
    //     ];
    // }
}