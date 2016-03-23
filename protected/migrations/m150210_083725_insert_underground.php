<?php

class m150210_083725_insert_underground extends CDbMigration
{
	/*public function up()
	{
	}

	public function down()
	{
		echo "m150210_083725_insert_underground does not support migration down.\n";
		return false;
	}*/


	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
		$this->execute("
			INSERT INTO `Underground` VALUES ('1', 'Авиамоторная', '1', '55.751579', '37.716976',0);
			INSERT INTO `Underground` VALUES ('2', 'Автозаводская', '1', '55.707748', '37.657497',0);
			INSERT INTO `Underground` VALUES ('3', 'Академическая', '1', '55.687790', '37.573387',0);
			INSERT INTO `Underground` VALUES ('4', 'Александровский Сад', '1', '55.752258', '37.610222',0);
			INSERT INTO `Underground` VALUES ('5', 'Алексеевская', '1', '55.807789', '37.638718',0);
			INSERT INTO `Underground` VALUES ('6', 'Алтуфьево', '1', '55.897923', '37.587139',0);
			INSERT INTO `Underground` VALUES ('7', 'Аннино', '1', '55.583691', '37.596783',0);
			INSERT INTO `Underground` VALUES ('8', 'Арбатская (ар.)', '1', '55.755787', '37.617634',0);
			INSERT INTO `Underground` VALUES ('9', 'Арбатская (фил.)', '1', '55.755787', '37.617634',0);
			INSERT INTO `Underground` VALUES ('10', 'Аэропорт', '1', '55.800671', '37.532200',0);
			INSERT INTO `Underground` VALUES ('11', 'Бабушкинская', '1', '55.869858', '37.664242',0);
			INSERT INTO `Underground` VALUES ('12', 'Багратионовская', '1', '55.743786', '37.497715',0);
			INSERT INTO `Underground` VALUES ('13', 'Баррикадная', '1', '55.760754', '37.581234',0);
			INSERT INTO `Underground` VALUES ('14', 'Бауманская', '1', '55.772366', '37.678825',0);
			INSERT INTO `Underground` VALUES ('15', 'Беговая', '1', '55.773590', '37.547138',0);
			INSERT INTO `Underground` VALUES ('16', 'Белорусская', '1', '55.776920', '37.584126',0);
			INSERT INTO `Underground` VALUES ('17', 'Беляево', '1', '55.642654', '37.526272',0);
			INSERT INTO `Underground` VALUES ('18', 'Бибирево', '1', '55.883926', '37.603630',0);
			INSERT INTO `Underground` VALUES ('19', 'Библиотека имени Ленина', '1', '55.751389', '37.609722',0);
			INSERT INTO `Underground` VALUES ('20', 'Битцевский Парк', '1', '55.599167', '37.556946',0);
			INSERT INTO `Underground` VALUES ('21', 'Боровицкая', '1', '55.752304', '37.612877',0);
			INSERT INTO `Underground` VALUES ('22', 'Ботанический Сад', '1', '55.845478', '37.638409',0);
			INSERT INTO `Underground` VALUES ('23', 'Братиславская', '1', '55.659416', '37.750462',0);
			INSERT INTO `Underground` VALUES ('24', 'Бульвар Дмитрия Донского', '1', '55.570244', '37.577145',0);
			INSERT INTO `Underground` VALUES ('25', 'Бунинская аллея', '1', '55.537945', '37.515362',0);
			INSERT INTO `Underground` VALUES ('26', 'Варшавская', '1', '55.653545', '37.620480',0);
			INSERT INTO `Underground` VALUES ('27', 'ВДНХ', '1', '55.820732', '37.640697',0);
			INSERT INTO `Underground` VALUES ('28', 'Владыкино', '1', '55.847183', '37.589916',0);
			INSERT INTO `Underground` VALUES ('29', 'Водный Стадион', '1', '55.839844', '37.486820',0);
			INSERT INTO `Underground` VALUES ('30', 'Войковская', '1', '55.818790', '37.498028',0);
			INSERT INTO `Underground` VALUES ('31', 'Волгоградский Проспект', '1', '55.724899', '37.687134',0);
			INSERT INTO `Underground` VALUES ('32', 'Волжская', '1', '55.690865', '37.754219',0);
			INSERT INTO `Underground` VALUES ('33', 'Волоколамская (стр.)', '1', '55.755787', '37.617634',0);
			INSERT INTO `Underground` VALUES ('34', 'Воробьевы горы', '1', '55.710308', '37.559219',0);
			INSERT INTO `Underground` VALUES ('35', 'Выхино', '1', '55.715805', '37.818024',0);
			INSERT INTO `Underground` VALUES ('36', 'Горчакова ул.', '1', '55.541962', '37.531132',0);
			INSERT INTO `Underground` VALUES ('37', 'Деловой центр', '1', '55.749222', '37.543285',0);
			INSERT INTO `Underground` VALUES ('38', 'Динамо', '1', '55.789749', '37.558189',0);
			INSERT INTO `Underground` VALUES ('39', 'Дмитровская', '1', '55.807999', '37.581066',0);
			INSERT INTO `Underground` VALUES ('40', 'Добрынинская', '1', '55.728992', '37.622787',0);
			INSERT INTO `Underground` VALUES ('41', 'Домодедовская', '1', '55.610634', '37.718033',0);
			INSERT INTO `Underground` VALUES ('42', 'Дубровка', '1', '55.717850', '37.676556',0);
			INSERT INTO `Underground` VALUES ('43', 'Измайловская', '1', '55.787731', '37.781597',0);
			INSERT INTO `Underground` VALUES ('44', 'Калужская', '1', '55.656601', '37.539955',0);
			INSERT INTO `Underground` VALUES ('45', 'Кантемировская', '1', '55.635803', '37.656513',0);
			INSERT INTO `Underground` VALUES ('46', 'Каховская', '1', '55.652985', '37.598343',0);
			INSERT INTO `Underground` VALUES ('47', 'Каширская', '1', '55.655067', '37.648666',0);
			INSERT INTO `Underground` VALUES ('48', 'Киевская', '1', '55.743305', '37.565807',0);
			INSERT INTO `Underground` VALUES ('49', 'Китай-Город', '1', '55.755367', '37.632343',0);
			INSERT INTO `Underground` VALUES ('50', 'Кожуховская', '1', '55.706142', '37.685642',0);
			INSERT INTO `Underground` VALUES ('51', 'Коломенская', '1', '55.677906', '37.663727',0);
			INSERT INTO `Underground` VALUES ('52', 'Комсомольская', '1', '55.775448', '37.655964',0);
			INSERT INTO `Underground` VALUES ('53', 'Коньково', '1', '55.633553', '37.519413',0);
			INSERT INTO `Underground` VALUES ('54', 'Красногвардейская', '1', '55.613853', '37.744473',0);
			INSERT INTO `Underground` VALUES ('55', 'Краснопресненская', '1', '55.760216', '37.577251',0);
			INSERT INTO `Underground` VALUES ('56', 'Красносельская', '1', '55.779964', '37.666084',0);
			INSERT INTO `Underground` VALUES ('57', 'Красные Ворота', '1', '55.768875', '37.649067',0);
			INSERT INTO `Underground` VALUES ('58', 'Крестьянская застава', '1', '55.732269', '37.665592',0);
			INSERT INTO `Underground` VALUES ('59', 'Кропоткинская', '1', '55.745346', '37.603348',0);
			INSERT INTO `Underground` VALUES ('60', 'Крылатское', '1', '55.756790', '37.408096',0);
			INSERT INTO `Underground` VALUES ('61', 'Кузнецкий Мост', '1', '55.761509', '37.624149',0);
			INSERT INTO `Underground` VALUES ('62', 'Кузьминки', '1', '55.705429', '37.765682',0);
			INSERT INTO `Underground` VALUES ('63', 'Кунцевская', '1', '55.730698', '37.445919',0);
			INSERT INTO `Underground` VALUES ('64', 'Курская', '1', '55.758183', '37.661484',0);
			INSERT INTO `Underground` VALUES ('65', 'Кутузовская', '1', '55.740040', '37.534569',0);
			INSERT INTO `Underground` VALUES ('66', 'Ленинский Проспект', '1', '55.707661', '37.586185',0);
			INSERT INTO `Underground` VALUES ('67', 'Лубянка', '1', '55.759342', '37.626850',0);
			INSERT INTO `Underground` VALUES ('68', 'Люблино', '1', '55.676300', '37.761852',0);
			INSERT INTO `Underground` VALUES ('69', 'Марксистская', '1', '55.740913', '37.656425',0);
			INSERT INTO `Underground` VALUES ('70', 'Марьино', '1', '55.650089', '37.743809',0);
			INSERT INTO `Underground` VALUES ('71', 'Маяковская', '1', '55.769936', '37.596046',0);
			INSERT INTO `Underground` VALUES ('72', 'Медведково', '1', '55.887074', '37.661388',0);
			INSERT INTO `Underground` VALUES ('73', 'Международная', '1', '55.748329', '37.532825',0);
			INSERT INTO `Underground` VALUES ('74', 'Менделеевская', '1', '55.781910', '37.598583',0);
			INSERT INTO `Underground` VALUES ('75', 'Митино (стр.)', '1', '55.872944', '37.451054',0);
			INSERT INTO `Underground` VALUES ('76', 'Молодежная', '1', '55.740807', '37.416832',0);
			INSERT INTO `Underground` VALUES ('77', 'Нагатинская', '1', '55.682728', '37.621819',0);
			INSERT INTO `Underground` VALUES ('78', 'Нагорная', '1', '55.672981', '37.610760',0);
			INSERT INTO `Underground` VALUES ('79', 'Нахимовский Проспект', '1', '55.662846', '37.605583',0);
			INSERT INTO `Underground` VALUES ('80', 'Новогиреево', '1', '55.751801', '37.816002',0);
			INSERT INTO `Underground` VALUES ('81', 'Новокузнецкая', '1', '55.742382', '37.629257',0);
			INSERT INTO `Underground` VALUES ('82', 'Новослободская', '1', '55.779514', '37.601166',0);
			INSERT INTO `Underground` VALUES ('83', 'Новые Черёмушки', '1', '55.670261', '37.554600',0);
			INSERT INTO `Underground` VALUES ('84', 'Октябрьская', '1', '55.730255', '37.612240',0);
			INSERT INTO `Underground` VALUES ('85', 'Октябрьское Поле', '1', '55.793526', '37.493404',0);
			INSERT INTO `Underground` VALUES ('86', 'Орехово', '1', '55.613449', '37.694496',0);
			INSERT INTO `Underground` VALUES ('87', 'Отрадное', '1', '55.863319', '37.604694',0);
			INSERT INTO `Underground` VALUES ('88', 'Охотный Ряд', '1', '55.756706', '37.615906',0);
			INSERT INTO `Underground` VALUES ('89', 'Павелецкая', '1', '55.730663', '37.636787',0);
			INSERT INTO `Underground` VALUES ('90', 'Парк Культуры', '1', '55.735645', '37.594002',0);
			INSERT INTO `Underground` VALUES ('91', 'Парк Победы', '1', '55.736301', '37.517002',0);
			INSERT INTO `Underground` VALUES ('92', 'Партизанская', '1', '55.788437', '37.749626',0);
			INSERT INTO `Underground` VALUES ('93', 'Первомайская', '1', '55.794617', '37.799335',0);
			INSERT INTO `Underground` VALUES ('94', 'Перово', '1', '55.751095', '37.785938',0);
			INSERT INTO `Underground` VALUES ('95', 'Петровско-Разумовская', '1', '55.836391', '37.575424',0);
			INSERT INTO `Underground` VALUES ('96', 'Печатники', '1', '55.692928', '37.727657',0);
			INSERT INTO `Underground` VALUES ('97', 'Пионерская', '1', '55.736027', '37.467033',0);
			INSERT INTO `Underground` VALUES ('98', 'Планерная', '1', '55.860649', '37.436306',0);
			INSERT INTO `Underground` VALUES ('99', 'Площадь Ильича', '1', '55.747047', '37.680367',0);
			INSERT INTO `Underground` VALUES ('100', 'Площадь Революции', '1', '55.756542', '37.621658',0);
			INSERT INTO `Underground` VALUES ('101', 'Полежаевская', '1', '55.777554', '37.518940',0);
			INSERT INTO `Underground` VALUES ('102', 'Полянка', '1', '55.736771', '37.618443',0);
			INSERT INTO `Underground` VALUES ('103', 'Пражская', '1', '55.611889', '37.603813',0);
			INSERT INTO `Underground` VALUES ('104', 'Преображенская Площадь', '1', '55.796104', '37.715588',0);
			INSERT INTO `Underground` VALUES ('105', 'Пролетарская', '1', '55.731724', '37.665592',0);
			INSERT INTO `Underground` VALUES ('106', 'Проспект Вернадского', '1', '55.676716', '37.505573',0);
			INSERT INTO `Underground` VALUES ('107', 'Проспект Мира', '1', '55.780720', '37.633446',0);
			INSERT INTO `Underground` VALUES ('108', 'Профсоюзная', '1', '55.677929', '37.562840',0);
			INSERT INTO `Underground` VALUES ('109', 'Пушкинская', '1', '55.765953', '37.604179',0);
			INSERT INTO `Underground` VALUES ('110', 'Речной Вокзал', '1', '55.855015', '37.476139',0);
			INSERT INTO `Underground` VALUES ('111', 'Рижская', '1', '55.792484', '37.636097',0);
			INSERT INTO `Underground` VALUES ('112', 'Римская', '1', '55.746445', '37.680157',0);
			INSERT INTO `Underground` VALUES ('113', 'Рязанский Проспект', '1', '55.716949', '37.793243',0);
			INSERT INTO `Underground` VALUES ('114', 'Савеловская', '1', '55.794029', '37.589176',0);
			INSERT INTO `Underground` VALUES ('115', 'Свиблово', '1', '55.855206', '37.652699',0);
			INSERT INTO `Underground` VALUES ('116', 'Севастопольская', '1', '55.651352', '37.598354',0);
			INSERT INTO `Underground` VALUES ('117', 'Семеновская', '1', '55.783100', '37.719341',0);
			INSERT INTO `Underground` VALUES ('118', 'Серпуховская', '1', '55.726791', '37.625240',0);
			INSERT INTO `Underground` VALUES ('119', 'Скобелевская', '1', '55.547405', '37.555481',0);
			INSERT INTO `Underground` VALUES ('120', 'Смоленская (ар.)', '1', '55.755787', '37.617634',0);
			INSERT INTO `Underground` VALUES ('121', 'Смоленская (фил.)', '1', '55.755787', '37.617634',0);
			INSERT INTO `Underground` VALUES ('122', 'Сокол', '1', '55.804844', '37.515484',0);
			INSERT INTO `Underground` VALUES ('123', 'Сокольники', '1', '55.789284', '37.679726',0);
			INSERT INTO `Underground` VALUES ('124', 'Спортивная', '1', '55.723099', '37.563766',0);
			INSERT INTO `Underground` VALUES ('125', 'Старокачаловская', '1', '55.569706', '37.584190',0);
			INSERT INTO `Underground` VALUES ('126', 'Строгино (стр.)', '1', '55.806946', '37.498055',0);
			INSERT INTO `Underground` VALUES ('127', 'Студенческая', '1', '55.738907', '37.548126',0);
			INSERT INTO `Underground` VALUES ('128', 'Сухаревская', '1', '55.772308', '37.632507',0);
			INSERT INTO `Underground` VALUES ('129', 'Сходненская', '1', '55.850266', '37.439934',0);
			INSERT INTO `Underground` VALUES ('130', 'Таганская', '1', '55.740425', '37.653362',0);
			INSERT INTO `Underground` VALUES ('131', 'Тверская', '1', '55.765038', '37.605007',0);
			INSERT INTO `Underground` VALUES ('132', 'Театральная', '1', '55.758747', '37.617695',0);
			INSERT INTO `Underground` VALUES ('133', 'Текстильщики', '1', '55.708691', '37.730728',0);
			INSERT INTO `Underground` VALUES ('134', 'Теплый Стан', '1', '55.618874', '37.507046',0);
			INSERT INTO `Underground` VALUES ('135', 'Тимирязевская', '1', '55.819046', '37.575466',0);
			INSERT INTO `Underground` VALUES ('136', 'Третьяковская', '1', '55.740696', '37.625576',0);
			INSERT INTO `Underground` VALUES ('137', 'Тульская', '1', '55.708702', '37.622494',0);
			INSERT INTO `Underground` VALUES ('138', 'Тургеневская', '1', '55.766014', '37.636921',0);
			INSERT INTO `Underground` VALUES ('139', 'Тушинская', '1', '55.826923', '37.437359',0);
			INSERT INTO `Underground` VALUES ('140', 'Улица 1905 года', '1', '55.764763', '37.561371',0);
			INSERT INTO `Underground` VALUES ('141', 'Улица Академика Янгеля', '1', '55.595482', '37.601173',0);
			INSERT INTO `Underground` VALUES ('142', 'Улица Подбельского', '1', '55.814461', '37.734020',0);
			INSERT INTO `Underground` VALUES ('143', 'Университет', '1', '55.692574', '37.534542',0);
			INSERT INTO `Underground` VALUES ('144', 'Ушакова Адмирала', '1', '55.545261', '37.542072',0);
			INSERT INTO `Underground` VALUES ('145', 'Филевский Парк', '1', '55.739540', '37.483265',0);
			INSERT INTO `Underground` VALUES ('146', 'Фили', '1', '55.746048', '37.514874',0);
			INSERT INTO `Underground` VALUES ('147', 'Фрунзенская', '1', '55.727463', '37.580502',0);
			INSERT INTO `Underground` VALUES ('148', 'Царицыно', '1', '55.621056', '37.669456',0);
			INSERT INTO `Underground` VALUES ('149', 'Цветной Бульвар', '1', '55.771656', '37.620575',0);
			INSERT INTO `Underground` VALUES ('150', 'Черкизовская', '1', '55.803844', '37.744694',0);
			INSERT INTO `Underground` VALUES ('151', 'Чертановская', '1', '55.640709', '37.605751',0);
			INSERT INTO `Underground` VALUES ('152', 'Чеховская', '1', '55.765865', '37.608139',0);
			INSERT INTO `Underground` VALUES ('153', 'Чистые Пруды', '1', '55.764904', '37.638344',0);
			INSERT INTO `Underground` VALUES ('154', 'Чкаловская', '1', '55.756001', '37.658749',0);
			INSERT INTO `Underground` VALUES ('155', 'Шаболовская', '1', '55.718826', '37.607914',0);
			INSERT INTO `Underground` VALUES ('156', 'Шоссе Энтузиастов', '1', '55.758167', '37.751667',0);
			INSERT INTO `Underground` VALUES ('157', 'Щелковская', '1', '55.809608', '37.798588',0);
			INSERT INTO `Underground` VALUES ('158', 'Щукинская', '1', '55.808510', '37.464344',0);
			INSERT INTO `Underground` VALUES ('159', 'Электрозаводская', '1', '55.782024', '37.705219',0);
			INSERT INTO `Underground` VALUES ('160', 'Юго-Западная', '1', '55.663681', '37.483196',0);
			INSERT INTO `Underground` VALUES ('161', 'Южная', '1', '55.622299', '37.608994',0);
			INSERT INTO `Underground` VALUES ('162', 'Ясенево', '1', '55.606220', '37.533340',0);
			INSERT INTO `Underground` VALUES ('163', 'Девяткино', '2', '60.050182', '30.443045',0);
			INSERT INTO `Underground` VALUES ('164', 'Гражданский проспект', '2', '60.034969', '30.418224',0);
			INSERT INTO `Underground` VALUES ('165', 'Академическая', '2', '60.012806', '30.396044',0);
			INSERT INTO `Underground` VALUES ('166', 'Политехническая', '2', '60.008942', '30.370907',0);
			INSERT INTO `Underground` VALUES ('167', 'Площадь Мужества', '2', '59.999828', '30.366159',0);
			INSERT INTO `Underground` VALUES ('168', 'Лесная', '2', '59.984947', '30.344259',0);
			INSERT INTO `Underground` VALUES ('169', 'Выборгская', '2', '59.971649', '30.348478',0);
			INSERT INTO `Underground` VALUES ('170', 'Площадь Ленина', '2', '59.957260', '30.355383',0);
			INSERT INTO `Underground` VALUES ('171', 'Чернышевская', '2', '59.944530', '30.359919',0);
			INSERT INTO `Underground` VALUES ('172', 'Площадь Восстания', '2', '59.930279', '30.361069',0);
			INSERT INTO `Underground` VALUES ('173', 'Владимирская', '2', '59.927628', '30.347898',0);
			INSERT INTO `Underground` VALUES ('174', 'Пушкинская', '2', '59.920650', '30.329599',0);
			INSERT INTO `Underground` VALUES ('175', 'Балтийская', '2', '59.907211', '30.299578',0);
			INSERT INTO `Underground` VALUES ('176', 'Нарвская', '2', '59.901218', '30.274908',0);
			INSERT INTO `Underground` VALUES ('177', 'Кировский завод', '2', '59.879688', '30.261921',0);
			INSERT INTO `Underground` VALUES ('178', 'Автово', '2', '59.867325', '30.261337',0);
			INSERT INTO `Underground` VALUES ('179', 'Ленинский проспект', '2', '59.851170', '30.268274',0);
			INSERT INTO `Underground` VALUES ('180', 'Проспект Ветеранов', '2', '59.841835', '30.251949',0);
			INSERT INTO `Underground` VALUES ('181', 'Парнас', '2', '60.066990', '30.333839',0);
			INSERT INTO `Underground` VALUES ('182', 'Проспект Просвещения', '2', '60.051456', '30.332544',0);
			INSERT INTO `Underground` VALUES ('183', 'Озерки', '2', '60.037098', '30.321495',0);
			INSERT INTO `Underground` VALUES ('184', 'Удельная', '2', '60.016697', '30.315607',0);
			INSERT INTO `Underground` VALUES ('185', 'Пионерская', '2', '60.002487', '30.296759',0);
			INSERT INTO `Underground` VALUES ('186', 'Чёрная речка', '2', '59.985455', '30.300833',0);
			INSERT INTO `Underground` VALUES ('187', 'Петроградская', '2', '59.966389', '30.311293',0);
			INSERT INTO `Underground` VALUES ('188', 'Горьковская', '2', '59.956112', '30.318890',0);
			INSERT INTO `Underground` VALUES ('189', 'Невский проспект', '2', '59.935051', '30.329725',0);
			INSERT INTO `Underground` VALUES ('190', 'Сенная площадь', '2', '59.927135', '30.320316',0);
			INSERT INTO `Underground` VALUES ('191', 'Технологический институт', '2', '59.916512', '30.318485',0);
			INSERT INTO `Underground` VALUES ('192', 'Фрунзенская', '2', '59.906273', '30.317450',0);
			INSERT INTO `Underground` VALUES ('193', 'Московские ворота', '2', '59.891788', '30.317873',0);
			INSERT INTO `Underground` VALUES ('194', 'Электросила', '2', '59.879189', '30.318659',0);
			INSERT INTO `Underground` VALUES ('195', 'Парк Победы', '2', '59.866344', '30.321802',0);
			INSERT INTO `Underground` VALUES ('196', 'Московская', '2', '59.851341', '30.321548',0);
			INSERT INTO `Underground` VALUES ('197', 'Звёздная', '2', '59.833241', '30.349428',0);
			INSERT INTO `Underground` VALUES ('198', 'Купчино', '2', '59.829781', '30.375702',0);
			INSERT INTO `Underground` VALUES ('199', 'Приморская', '2', '59.948521', '30.234470',0);
			INSERT INTO `Underground` VALUES ('200', 'Василеостровская', '2', '59.942577', '30.278254',0);
			INSERT INTO `Underground` VALUES ('201', 'Гостиный двор', '2', '59.933933', '30.333410',0);
			INSERT INTO `Underground` VALUES ('202', 'Маяковская', '2', '59.931366', '30.354645',0);
			INSERT INTO `Underground` VALUES ('203', 'Площадь Александра Невского-1', '2', null, null,0);
			INSERT INTO `Underground` VALUES ('204', 'Елизаровская', '2', '59.896690', '30.423656',0);
			INSERT INTO `Underground` VALUES ('205', 'Ломоносовская', '2', '59.877342', '30.441715',0);
			INSERT INTO `Underground` VALUES ('206', 'Пролетарская', '2', '59.865215', '30.470264',0);
			INSERT INTO `Underground` VALUES ('207', 'Обухово', '2', '59.848709', '30.457743',0);
			INSERT INTO `Underground` VALUES ('208', 'Рыбацкое', '2', '59.830986', '30.501259',0);
			INSERT INTO `Underground` VALUES ('209', 'Спасская', '2', '59.927135', '30.320316',0);
			INSERT INTO `Underground` VALUES ('210', 'Достоевская', '2', '59.928234', '30.346029',0);
			INSERT INTO `Underground` VALUES ('211', 'Лиговский проспект', '2', '59.920811', '30.355055',0);
			INSERT INTO `Underground` VALUES ('212', 'Площадь Александра Невского-2', '2', null, null,0);
			INSERT INTO `Underground` VALUES ('213', 'Новочеркасская', '2', '59.929092', '30.411915',0);
			INSERT INTO `Underground` VALUES ('214', 'Ладожская', '2', '59.932430', '30.439274',0);
			INSERT INTO `Underground` VALUES ('215', 'Проспект Большевиков', '2', '59.919838', '30.466757',0);
			INSERT INTO `Underground` VALUES ('216', 'Улица Дыбенко', '2', '59.907417', '30.483311',0);
			INSERT INTO `Underground` VALUES ('217', 'Комендантский проспект', '2', '60.008591', '30.258663',0);
			INSERT INTO `Underground` VALUES ('218', 'Старая Деревня', '2', '59.989433', '30.255163',0);
			INSERT INTO `Underground` VALUES ('219', 'Крестовский остров', '2', '59.971821', '30.259436',0);
			INSERT INTO `Underground` VALUES ('220', 'Чкаловская', '2', '59.961033', '30.292006',0);
			INSERT INTO `Underground` VALUES ('221', 'Спортивная', '2', '59.952026', '30.291338',0);
			INSERT INTO `Underground` VALUES ('222', 'Садовая', '2', '59.926739', '30.317753',0);
			INSERT INTO `Underground` VALUES ('223', 'Звенигородская', '2', '59.920650', '30.329599',0);
			INSERT INTO `Underground` VALUES ('224', 'Волковская', '2', '59.896023', '30.357540',0);
			INSERT INTO `Underground` VALUES ('225', 'Трубная', '1', '55.767445', '37.622059',0);
		");
	}

	public function safeDown()
	{
		$this->execute("
			TRUNCATE TABLE `Underground`;
		");
	}

}