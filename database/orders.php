<?php

$columns = [
  ['column' => 'item_id', 'type' => 'INT NOT NULL'],
  ['column' => 'receiving', 'type' => 'DATETIME NOT NULL'],
  ['column' => 'order_count', 'type' => 'INT NOT NULL'],
  ['column' => 'name', 'type' => 'VARCHAR(50) NOT NULL'],
  ['column' => 'tel', 'type' => 'TEXT NOT NULL'],
  ['column' => 'email', 'type' => 'TEXT NOT NULL'],
  ['column' => 'status', 'type' => 'INT DEFAULT 1'],
];