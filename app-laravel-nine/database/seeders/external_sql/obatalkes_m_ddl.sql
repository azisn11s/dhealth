CREATE TABLE `obatalkes_m`  (
  `obatalkes_id` int(11) NOT NULL AUTO_INCREMENT,
  `obatalkes_kode` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `obatalkes_nama` varchar(250) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL,
  `stok` decimal(15, 2) NULL DEFAULT NULL,
  `additional_data` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL,
  `created_date` datetime(0) NOT NULL DEFAULT CURRENT_TIMESTAMP(0),
  `created_by` int(11) NULL DEFAULT NULL,
  `modified_count` int(11) NULL DEFAULT NULL,
  `last_modified_date` datetime(0) NULL DEFAULT NULL,
  `last_modified_by` int(11) NULL DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `deleted_date` datetime(0) NULL DEFAULT NULL,
  `deleted_by` int(11) NULL DEFAULT NULL,
  PRIMARY KEY (`obatalkes_id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2501 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;