<?php
  $patternCategories = array();
  $patternNames = array();
  $patternDescriptions = array();

  //Read patterns list
  //efficacy patterns list: 'data/eff-patterns.csv'
  //experience patterns list: 'data/exp-patterns.csv'
  function readPatternsList($patternListFileName) {
    global $patternCategories;
    global $patternNames;
    global $patternDescriptions;

    $fh = fopen($patternListFileName, 'r');
    while (($data = fgetcsv($fh, 0, ",")) !== FALSE) {
      if ($data[0] == "id") {
        continue;
      }
      $patternCategories[$data[0]] = $data[1];
      $patternNames[$data[0]] = $data[2];
      $patternDescriptions[$data[0]] = $data[3];
    }
  }

  //Get pattern name by id
  function getPatternNameByID ($patternID) {
    global $patternNames;
    return $patternNames[$patternID];
  }

  //Get pattern category by id
  function getPatternCategoryByID ($patternID) {
    global $patternCategories;
    return $patternCategories[$patternID];
  }

  //Get pattern description by id
  function getPatternDescriptionByID ($patternID) {
    global $patternDescriptions;
    return $patternDescriptions[$patternID];
  }

  //Get pattern ids by category
  function getPatternIDsByCategory ($category) {
    global $patternCategories;
    return array_keys($patternCategories, $category);
  }

  //Get pattern id by name
  function getPatternIDByName ($pName) {
    global $patternNames;
    foreach ($patternNames as $id => $name) {
      if ($pName == $name) {
        return $id;
      }
    }
  }

  //////////////////////////////////////////////////////////
  ///////////              GOALS            ////////////////
  //////////////////////////////////////////////////////////
  $goalName = array();
  $goalType = array();
  $mappingGoalID = array();
  $mappingEffPatternID = array();

  //Read goals list and patterns by goal mapping
  function readGoals() {
    global $goalName;
    global $goalType;
    global $mappingGoalID;
    global $mappingEffPatternID;

    $fh = fopen('data/therapy-goal.csv', 'r');
    while (($data = fgetcsv($fh, 0, ",")) !== FALSE) {
      if ($data[0] == "id") {
        continue;
      }
      $goalName[$data[0]] = $data[1];
      $goalType[$data[0]] = $data[2];
    }

    //Read patterns by goal mapping
    $fh = fopen('data/eff-patterns-by-goal.csv', 'r');
    $i = 0;
    while (($data = fgetcsv($fh, 0, ",")) !== FALSE) {
      if ($data[0] == "goal-id") {
        continue;
      }

      $mappingGoalID[$i] = strval($data[0]);
      $mappingEffPatternID[$i] = strval($data[1]);
      ++$i;
    }
  }

  //Get used physical goals
  function getUsedPhysicalGoals() {
    global $goalType;
    global $goalName;
    global $mappingGoalID;

    $usedPhyGoals = array();

    $usedGoalIds = array_unique($mappingGoalID);
    foreach ($usedGoalIds as $id) {
      if ($goalType[$id] == "phy") {
        $usedPhyGoals[$id] = $goalName[$id];
      }
    }
    return $usedPhyGoals;
  }

  //Get used cognitive goal ids
  function getUsedCognitiveGoals() {
    global $goalType;
    global $goalName;
    global $mappingGoalID;

    $usedCogGoals = array();

    $usedGoalIds = array_unique($mappingGoalID);
    foreach ($usedGoalIds as $id) {
      if ($goalType[$id] == "cog") {
        $usedCogGoals[$id] = $goalName[$id];
      }
    }
    return $usedCogGoals;
  }

  //Get pattern goals
  function getGoalsAssociatedWithPattern ($patternID)
  {
    global $goalName;
    global $mappingGoalID;
    global $mappingEffPatternID;

    $goals = array();

    $mappingKeys = array_keys($mappingEffPatternID, $patternID);
    foreach ($mappingKeys as $mappingKey) {
      $goalID = $mappingGoalID[$mappingKey];
      $goals[$goalID] = $goalName[$goalID];
    }

    return $goals;
  }

  //Get pattern ids by goal id
  function getPatternIDsByGoal ($goalID) {
    global $mappingGoalID;
    global $mappingEffPatternID;

    $patternIDs = array();

    $mappingKeys = array_keys($mappingGoalID, $goalID);
    foreach ($mappingKeys as $mappingKey) {
      array_push($patternIDs, $mappingEffPatternID[$mappingKey]);
    }

    return $patternIDs;
  }

  //////////////////////////////////////////////////////////
  ///////////            COMMENTS           ////////////////
  //////////////////////////////////////////////////////////
  $gameComments = array();
  function readComments() {
    global $gameComments;

    if (file_exists('data/patterns/example-games/game-comments.json')) {
			$jsonData = file_get_contents('data/patterns/example-games/game-comments.json');
      $temp = json_decode($jsonData, true);
      foreach ($temp as $value) {
        $gameComments[$value["GameID"]][] = array(
          'TherapistType' => $value["TherapistType"],
          'Comments' => $value["Comments"]
        );
      }
		}
  }

  function getComments($gameID) {
    global $gameComments;
    return $gameComments[$gameID];
  }
?>
