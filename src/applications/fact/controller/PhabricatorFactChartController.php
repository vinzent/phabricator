<?php

/*
 * Copyright 2012 Facebook, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

final class PhabricatorFactChartController extends PhabricatorFactController {

  public function processRequest() {
    $request = $this->getRequest();
    $user = $request->getUser();

    $table = new PhabricatorFactRaw();
    $conn_r = $table->establishConnection('r');
    $table_name = $table->getTableName();

    $series = $request->getStr('y1');

    $specs = PhabricatorFactSpec::newSpecsForFactTypes(
      PhabricatorFactEngine::loadAllEngines(),
      array($series));
    $spec = idx($specs, $series);

    $data = queryfx_all(
      $conn_r,
      'SELECT valueX, epoch FROM %T WHERE factType = %s ORDER BY epoch ASC',
      $table_name,
      $series);

    $points = array();
    $sum = 0;
    foreach ($data as $key => $row) {
      $sum += (int)$row['valueX'];
      $points[(int)$row['epoch']] = $sum;
    }

    if (!$points) {
      // NOTE: Raphael crashes Safari if you hand it series with no points.
      throw new Exception("No data to show!");
    }

    $x = array_keys($points);
    $y = array_values($points);

    $id = celerity_generate_unique_node_id();
    $chart = phutil_render_tag(
      'div',
      array(
        'id' => $id,
        'style' => 'border: 1px solid #6f6f6f; '.
                   'margin: 1em 2em; '.
                   'background: #ffffff; '.
                   'height: 400px; ',
      ),
      '');

    require_celerity_resource('raphael-core');
    require_celerity_resource('raphael-g');
    require_celerity_resource('raphael-g-line');

    Javelin::initBehavior('line-chart', array(
      'hardpoint' => $id,
      'x' => array($x),
      'y' => array($y),
      'xformat' => 'epoch',
      'colors' => array('#0000ff'),
    ));

    $panel = new AphrontPanelView();
    $panel->setHeader('Count of '.$spec->getName());
    $panel->appendChild($chart);

    return $this->buildStandardPageResponse(
      $panel,
      array(
        'title' => 'Chart',
      ));
  }

}
