ALTER TABLE `item` 
  CHANGE `itemConsole` VARCHAR(32),
  CHANGE `itemCat`     VARCHAR(32),
  CHANGE `itemCond`    VARCHAR(16),
  CHANGE `itemStyle`   VARCHAR(32);

UPDATE `item` JOIN `console`   ON(`console`.`conID`    = `item`.`itemConsole`) SET `item`.`itemConsole` = `console`.`conText`    WHERE `item`.`itemConsole` = `console`.`conID`;
UPDATE `item` JOIN `category`  ON(`category`.`catID`   = `item`.`itemCat`)     SET `item`.`itemCat`     = `category`.`catText`   WHERE `item`.`itemCat`     = `category`.`catID`;
UPDATE `item` JOIN `condition` ON(`condition`.`condID` = `item`.`itemCond`)    SET `item`.`itemCond`    = `condition`.`condText` WHERE `item`.`itemCond`    = `condition`.`condID`;
UPDATE `item` JOIN `style`     ON(`style`.`styleID`    = `item`.`itemStyle`)   SET `item`.`itemStyle`   = `style`.`styleName`    WHERE `item`.`itemStyle`   = `style`.`styleID`;

