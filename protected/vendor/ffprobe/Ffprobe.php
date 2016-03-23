<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 19.02.14
 */


class Ffprobe {

    /**
     * @var string|null Путь к Ffprobe.exe
     */
    private $_pathToFfprobe;
    /**
     * @var bool
     */
    private $_isShowUnit;
    /**
     * @var bool
     */
    private $_isShowFormat;
    /**
     * @var bool
     */
    private $_isShowStreams;
    /**
     * @var bool
     */
    private $_isShowPrefix;
    /**
     * @var bool
     */
    private $_isShowByteBinaryPrefix;
    /**
     * @var bool
     */
    private $_isSexagesimal;
    /**
     * @var bool
     */
    private $_isPretty;
    /**
     * @var bool
     */
    private $_isShowSectionsInfo;
    /**
     * @var bool
     */
    private $_isShowData;
    /**
     * @var bool
     */
    private $_isShowError;
    /**
     * @var null|string
     */
    private $_showEntries;
    /**
     * @var bool
     */
    private $_isShowPackets;
    /**
     * @var bool
     */
    private $_isShowFrames;
    /**
     * @var bool
     */
    private $_isShowPrograms;
    /**
     * @var bool
     */
    private $_isShowChapters;
    /**
     * @var bool
     */
    private $_isShowCountFrames;
    /**
     * @var null|string
     */
    private $_readIntervals;

    /**
     * @var null|string
     */
    private $_selectStreams;

    /**
     * @var bool
     */
    private $_isShowProgramVersion;

    /**
     * @var bool
     */
    private $_isShowLibraryVersion;

    /**
     * @var bool
     */
    private $_isShowVersions;

    /**
     * @var bool
     */
    private $_isBitexact;

    /**
     * @var null|string
     */
    private $_printFormat;

    /**
     * @var array
     */
    private $_availablePrintFormats;

    /**
     * @var null|string
     */
    private $_printFormatOptions;

    /**
     * @var null|string
     */
    private $_output;

    /**
     * @var null|string
     */
    private $_errorsOutput;

    /**
     * @var null|string
     */
    private $_cwd;

    /**
     * @var bool
     */
    private $_isShowPrivateData;

    /**
     * @var null|string
     */
    private $_additionalParams;


    /**
     * @param string $pathToFfprobe
     * @throws Exception
     */
    function __construct($pathToFfprobe = 'ffprobe'){
        $this->setPathToFfprobe($pathToFfprobe);
        $check = $this->checkFfprobeExist($pathToFfprobe);
        if(!$check){
            throw new Exception("Ffprobe not found");
        }
        else{
            $this->_setDefaultParams();
        }
    }

    /**
     * Clear params
     */
    public function clearParams(){
        $this->_setDefaultParams();
    }

    /**
     * Set default params
     */
    private function _setDefaultParams(){
        $this->_isShowUnit = false;
        $this->_isShowFormat = false;
        $this->_isShowStreams = false;
        $this->_isShowPrefix = false;
        $this->_isShowByteBinaryPrefix = false;
        $this->_isSexagesimal = false;
        $this->_isPretty = false;
        $this->_isShowSectionsInfo = false;
        $this->_isShowData = false;
        $this->_isShowError = false;
        $this->_showEntries = NULL;
        $this->_isShowPackets = false;
        $this->_isShowFrames = false;
        $this->_isShowPrograms = false;
        $this->_isShowChapters = false;
        $this->_isShowCountFrames = false;
        $this->_readIntervals = NULL;
        $this->_selectStreams = NULL;
        $this->_isShowProgramVersion = false;
        $this->_isShowLibraryVersion = false;
        $this->_isShowVersions = false;
        $this->_isBitexact = false;
        $this->_printFormat = NULL;
        $this->_availablePrintFormats = array("default","compact","csv","flat","ini","json","xml");
        $this->_printFormatOptions = NULL;
        $this->_output = NULL;
        $this->_errorsOutput = NULL;
        $this->_cwd = NULL;
        $this->_isShowPrivateData = false;
        $this->_additionalParams = NULL;
    }

    /**
     * @param null $path
     * @return Ffprobe
     */
    public function setPathToFfprobe($path = NULL){
        if($path != NULL && is_string($path)){
            $this->_pathToFfprobe = $path;
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPathToFfprobe(){
        return $this->_pathToFfprobe;
    }

    /**
     * @param bool $isShowFormat
     * @return Ffprobe
     */
    public function setIsShowFormat($isShowFormat = true){
        if($isShowFormat){
            $this->_isShowFormat = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowFormat(){
        return $this->_isShowFormat;
    }

    /**
     * @param bool $isShowUnit
     * @return Ffprobe
     */
    public function setIsShowUnit($isShowUnit = true){
        if($isShowUnit){
            $this->_isShowUnit = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowUnit(){
        return $this->_isShowUnit;
    }

    /**
     * @param bool $isShowStreams
     * @return Ffprobe
     */
    public function setIsShowStreams($isShowStreams = true){
        if($isShowStreams){
            $this->_isShowStreams = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowStreams(){
        return $this->_isShowStreams;
    }

    /**
     * @param bool $isShowPrefix
     * @return Ffprobe
     */
    public function setIsShowPrefix($isShowPrefix = true){
        if($isShowPrefix){
            $this->_isShowPrefix = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowPrefix(){
        return $this->_isShowPrefix;
    }

    /**
     * @param bool $isShowByteBinaryPrefix
     * @return Ffprobe
     */
    public function setIsShowByteBinaryPrefix($isShowByteBinaryPrefix = true){
        if($isShowByteBinaryPrefix){
            $this->_isShowByteBinaryPrefix = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowByteBinaryPrefix(){
        return $this->_isShowByteBinaryPrefix;
    }

    /**
     * @param bool $isSexagesimal
     * @return Ffprobe
     */
    public function setIsSexagesimal($isSexagesimal = true){
        if($isSexagesimal){
            $this->_isSexagesimal = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsSexagesimal(){
        return $this->_isSexagesimal;
    }

    /**
     * @param bool $isPretty
     * @return Ffprobe
     */
    public function setIsPretty($isPretty = true){
        if($isPretty){
            $this->_isPretty = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsPretty(){
        return $this->_isPretty;
    }

    /**
     * @param bool $isShowSectionsInfo
     * @return Ffprobe
     */
    public function setIsShowSectionsInfo($isShowSectionsInfo = true){
        if($isShowSectionsInfo){
            $this->_isShowSectionsInfo = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowSectionsInfo(){
        return $this->_isShowSectionsInfo;
    }

    /**
     * @param bool $isShowData
     * @return Ffprobe
     */
    public function setIsShowData($isShowData = true){
        if($isShowData){
            $this->_isShowData = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowData(){
        return $this->_isShowData;
    }

    /**
     * @param bool $isShowError
     * @return Ffprobe
     */
    public function setIsShowError($isShowError = true){
        if($isShowError){
            $this->_isShowError = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowError(){
        return $this->_isShowError;
    }

    /**
     * @param null|string $entries
     * @return Ffprobe
     */
    public function setShowEntries($entries = NULL){
        if($entries !=NULL && is_string($entries)){
            $this->_showEntries = $entries;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getShowEntries(){
        return $this->_showEntries;
    }

    /**
     * @param bool $isShowPackets
     * @return Ffprobe
     */
    public function setIsShowPackets($isShowPackets = true){
        if($isShowPackets){
            $this->_isShowPackets = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowPackets(){
        return $this->_isShowPackets;
    }

    /**
     * @param bool $isShowFrames
     * @return Ffprobe
     */
    public function setIsShowFrames($isShowFrames = true){
        if($isShowFrames){
            $this->_isShowFrames = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowFrames(){
        return $this->_isShowFrames;
    }

    /**
     * @param bool $isShowPrograms
     * @return Ffprobe
     */
    public function setIsShowPrograms($isShowPrograms = true){
        if($isShowPrograms){
            $this->_isShowPrograms = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowPrograms(){
        return $this->_isShowPrograms;
    }

    /**
     * @param bool $isShowChapters
     * @return Ffprobe
     */
    public function setIsShowChapters($isShowChapters = true){
        if($isShowChapters){
            $this->_isShowChapters = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowChapters(){
        return $this->_isShowChapters;
    }

    /**
     * @param bool $isShowCountFrames
     * @return Ffprobe
     */
    public function setIsShowCountFrames($isShowCountFrames = true){
        if($isShowCountFrames){
            $this->_isShowCountFrames = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowCountFrames(){
        return $this->_isShowCountFrames;
    }

    /**
     * @param null|string $readIntervals
     * @return Ffprobe
     */
    public function setReadIntervals($readIntervals = NULL){
        if($readIntervals !=NULL && is_string($readIntervals)){
            $this->_readIntervals = $readIntervals;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getReadIntervals(){
        return $this->_readIntervals;
    }

    /**
     * @param null|string $selectStreams
     * @return Ffprobe
     */
    public function setSelectStreams($selectStreams = NULL){
        if($selectStreams !=NULL && is_string($selectStreams)){
            $this->_selectStreams = $selectStreams;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSelectStreams(){
        return $this->_selectStreams;
    }

    /**
     * @param mixed $isShowProgramVersion
     * @return Ffprobe
     */
    public function setIsShowProgramVersion($isShowProgramVersion = true){
        if($isShowProgramVersion){
            $this->_isShowProgramVersion = $isShowProgramVersion;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowProgramVersion(){
        return $this->_isShowProgramVersion;
    }

    /**
     * @param mixed $isShowLibraryVersion
     * @return Ffprobe
     */
    public function setIsShowLibraryVersion($isShowLibraryVersion = true){
        if($isShowLibraryVersion){
            $this->_isShowLibraryVersion = $isShowLibraryVersion;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowLibraryVersion(){
        return $this->_isShowLibraryVersion;
    }

    /**
     * @param mixed $isShowVersions
     * @return Ffprobe
     */
    public function setIsShowVersions($isShowVersions = true){
        if($this->_isShowVersions){
            $this->_isShowVersions = $isShowVersions;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowVersions(){
        return $this->_isShowVersions;
    }

    /**
     * @param mixed $isBitexact
     * @return Ffprobe
     */
    public function setIsBitexact($isBitexact = true){
        if($isBitexact){
            $this->_isBitexact = $isBitexact;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsBitexact(){
        return $this->_isBitexact;
    }

    /**
     * @param mixed $printFormat
     * @return Ffprobe
     */
    public function setPrintFormat($printFormat = NULL){
        if($printFormat != NULL && is_string($printFormat)){
            $availablePrintFormats = $this->getAvailablePrintFormats();
            if(in_array($printFormat,$availablePrintFormats)){
                $this->_printFormat = $printFormat;
            }
            else $this->_printFormat = NULL;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrintFormat(){
        return $this->_printFormat;
    }

    /**
     * @return array
     */
    public function getAvailablePrintFormats(){
        return $this->_availablePrintFormats;
    }

    /**
     * @param mixed $printFormatOptions
     * @return Ffprobe
     */
    public function setPrintFormatOptions($printFormatOptions = NULL){
        if($printFormatOptions != NULL && is_string($printFormatOptions)){
            $this->_printFormatOptions = $printFormatOptions;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPrintFormatOptions(){
        return $this->_printFormatOptions;
    }

    /**
     * @param mixed $output
     * @return Ffprobe
     */
    public function setOutput($output = NULL){
        if($output != NULL && is_string($output) && file_exists($output)){
            $this->_output = $output;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutput(){
        return $this->_output;
    }

    /**
     * @param mixed $cwd
     * @return Ffprobe
     */
    public function setCwd($cwd = NULL){
        if($cwd != NULL && is_string($cwd) && is_dir($cwd)){
            $this->_cwd = $cwd;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCwd(){
        return $this->_cwd;
    }

    /**
     * @param mixed $errorsOutput
     * @return Ffprobe
     */
    public function setErrorsOutput($errorsOutput = NULL){
        if($errorsOutput != NULL && is_string($errorsOutput) && file_exists($errorsOutput)){
            $this->_errorsOutput = $errorsOutput;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getErrorsOutput(){
        return $this->_errorsOutput;
    }

    /**
     * @param boolean $isShowPrivateData
     * @return Ffprobe
     */
    public function setIsShowPrivateData($isShowPrivateData = true){
        if($isShowPrivateData){
            $this->_isShowPrivateData = $isShowPrivateData;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsShowPrivateData(){
        return $this->_isShowPrivateData;
    }

    /**
     * @param null|string $additionalParams
     * @return Ffprobe
     */
    public function setAdditionalParams($additionalParams = NULL){
        if($additionalParams != NULL && is_string($additionalParams)){
            $this->_additionalParams = $additionalParams;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAdditionalParams(){
        return $this->_additionalParams;
    }

    /**
     * @param $path
     * @return array|bool
     */
    private function _checkFfprobeExist($path){
        $result = $this->_setCommand($path.' -version');
        return $result;
    }

    /**
     * @param null $path
     * @return bool
     */
    public function checkFfprobeExist($path = NULL){
        $result = false;
        if($path != NULL && is_string($path)){
            $tmpResult =  $this->_checkFfprobeExist($path);
            if($tmpResult['status'] == 0){
                $result = true;
            }
            else{
                $result = false;
            }
        }
        return $result;
    }

    /* Параметры ffprobe:

    -unit                   Если указано, то данные возвращаются с еденицами измерения, если не указано то просто цифры.

    -show_format            Добавляет к выводу объект format.

    -show_streams           Добавляет к выводу объекты потоков.

    -prefix                 Устанавливает SI префиксы для отображаемых знаечений,
                            если опция -byte_binary_prefix не указана,
                            работает некорректно в некоторых величинах (не округляет)
                            (прим: переводит Byte в Gbyte, Bit в Mbit).

    -byte_binary_prefix     Устанавливает двоичные префиксы для байтовых значений,
                            работает только если установлен -prefix, работает некорректно в некоторых величинах (не округляет)
                            (прим: переводит Byte в Gibyte).

    -sexagesimal            Устанавливает шестидесятеричный формат отображения временных значений (HH:MM:SS.MICROSECONDS).

    -pretty                 Устанавливает формат отображения значений, а-ля "-unit -prefix -byte_binary_prefix -sexagesimal" (см. выше).

    -sections               Возвращает информацию о секциях и о структуре секций.
                            Output не предназначен чтобы быть проанализирован с помощью машины.

    -show_data              Добавляет вывод полезных данных, как шестнадцатеричный и ASCII дамп.
                            В сочетании с '-show_packets ", он будет сбрасывать данные пакеты.
                            В сочетании с '-show_streams ", он сбросит дамп кодека ExtraData.
                            Дамп возвращается в поле "extradata" или "data". Он может содержать символы новой строки.

    -show_error             Добавляет вывод ошибок при парсинге инпута в поле "error".

    -show_entries           Строка. Устанавливает парметры которые следует отобразить в выводе.
                            Формат строки в документации http://www.ffmpeg.org/ffprobe.html#Main-options

    -show_packets           Добавляет к выводу отображение информации о каждом пакете, содержащейся во входном мультимедийном потоке.
                            Информация для каждого отдельного пакета печатается в специальном разделе с именем "packets".

    -show_frames            Добавляет к выводу отображение информации о каждом кадре и субтитрах, содержащейся во входном мультимедийном потоке.
                            Информация для каждого отдельного кадра печатается в специальном разделе с именем "frame" или "subtitle".

    -show_programs          Добавляет к выводу отображение информации о программах и их потоках, содержащихся во входном мультимедийном потоке.
                            Каждый информационный поток печатается в специальном разделе с именем "program_stream".

    -show_chapters          Добавляет к выводу отображение информации о главах.
                            Каждая глава печатается в специальном разделе с именем "chapter".

    -count_frames           Добавляет к выводу количество кадров в потоке и отображает в соответствующем разделе потока.

    -count_packets          Добавляет к выводу количество пакетов в потоке и отображает в соответствующем разделе потока.

    -read_intervals         Строка. Задаёт интервал чтения. Формат строки в документации http://www.ffmpeg.org/ffprobe.html#Main-options

    -select_streams         Строка. Задаёт потоки, которые следует отобразить в выводе. Формат строки в документации http://www.ffmpeg.org/ffprobe.html#Main-options

    -show_program_version   Добавляет к выводу информацию о версии программы. Информация о версии печатается в разделе с именем "program_version".

    -show_library_versions  Добавляет к выводу информацию о версиях библиотек. Информация о версии для каждой библиотеки печатается в разделе с именем "library_version".

    -show_versions          Добавляет к выводу информацию о версии программы и версиях библиотек.
                            Это эквивалент одновременной установке '-show_program_version »и варианты'-show_library_versions.

    -bitexact               Принудительно bitexact вывод, полезный для производства продукции, которая не зависит от конкретной сборки. (хрень какая-то непонятная)

    -print_format,          Формат вывода. Формула ввода: "-print_format {имя формата}" или "-print_format {имя формата}[={опции формата}]".
                            Формат строки в документации http://www.ffmpeg.org/ffprobe.html#Writers.
                            Доступные на данный момент форматы: default,compact,csv,flat,ini,json,xml.

    -of                     Псевдоним -print_format

    -show_private_data      Добавляет к выводу приватные данные, то есть данные в зависимости от формата конкретного показанного элемента.
                            Эта опция включена по умолчанию, но вам, возможно, потребуется отключить ее для конкретных целей,
                            например, при создании XSD-совместимого вывода XML.

    -private                Псевдоним -show_private_data
*/

    /**
     * @param string|null $inputFile
     * @return string
     * @throws
     */
    private function _createCommand($inputFile = NULL){
        if(file_exists($inputFile) && $this->_pathToFfprobe != NULL){

            $command = $this->_pathToFfprobe.' -i "'.$inputFile.'"';

            if($this->_printFormat != NULL && is_string($this->_printFormat)){
                $command.=' -print_format '.$this->_printFormat;
                if($this->_printFormatOptions != NULL && is_string($this->_printFormatOptions)){
                    $command.=$this->_printFormatOptions;
                }
            }
            if($this->_isShowSectionsInfo){
                $command.=' -sections';
            }
            else{
                if($this->_isShowError){
                    $command.=' -show_error';
                }
                if($this->_isShowPackets){
                    $command.=' -show_packets';
                }
                if($this->_isShowFrames){
                    $command.=' -show_frames';
                }
                if($this->_isShowFormat){
                    $command.=' -show_format';
                }
                if($this->_isShowStreams){
                    $command.=' -show_streams';
                }
                if($this->_isShowData){
                    $command.=' -show_data';
                }
                if($this->_isShowPrograms){
                    $command.=' -show_programs';
                }
                if($this->_isShowChapters){
                    $command.=' -show_chapters';
                }
                if($this->_isShowCountFrames){
                    $command.=' -count_frames';
                }
                if($this->_isPretty){
                    $command.=' -pretty';
                }
                if($this->_isBitexact){
                    $command.=' -bitexact';
                }
                if($this->_isShowVersions){
                    $command.=' -show_versions';
                }
                if($this->_isShowPrivateData){
                    $command.=' -show_private_data';
                }
                else{
                    if($this->_isShowProgramVersion){
                        $command.=' -show_program_version';
                    }
                    if($this->_isShowLibraryVersion){
                        $command.=' -show_library_versions';
                    }
                }
                if($this->_showEntries != NULL && is_string($this->_showEntries)){
                    $command.=' -show_entries '.$this->_showEntries;
                }
                if($this->_readIntervals != NULL && is_string($this->_readIntervals)){
                    $command.=' -read_intervals '.$this->_readIntervals;
                }
                if($this->_selectStreams != NULL && is_string($this->_selectStreams)){
                    $command.=' -select_streams '.$this->_selectStreams;
                }
                else{
                    if($this->_isShowUnit){
                        $command.=' -unit';
                    }
                    if($this->_isShowPrefix){
                        $command.=' -prefix';
                        if($this->_isShowByteBinaryPrefix){
                            $command.=' -byte_binary_prefix';
                        }
                    }
                    if($this->_isSexagesimal){
                        $command.=' -sexagesimal';
                    }
                }
                if($this->_additionalParams != NULL && is_string($this->_additionalParams)){
                    $command.=' '.$this->_additionalParams;
                }
            }
            return $command;
        }
        else{
            throw new CHttpException(403,"Ffprobe doesn't exist");
        }
    }

    /**
     * @param string|null $command
     * @return array|bool
     */
    private function _setCommand($command = NULL){
        if(is_string($command)){
            $cwd = $this->_cwd;
            $descriptorSpec = $this->_getDescriptorSpec();
            $pipes = array();
            $process = proc_open($command, $descriptorSpec, $pipes, $cwd);

            if (is_resource($process)) {
                fclose($pipes[0]);

                $output = $this->getOutput();
                $errors = $this->getErrorsOutput();

                if($this->_output === NULL){
                    $output = stream_get_contents($pipes[1]);
                    fclose($pipes[1]);
                }

                if($this->_errorsOutput === NULL){
                    $errors = stream_get_contents($pipes[2]);
                    fclose($pipes[2]);
                }

                $status = proc_close($process);
            }

            return array(
                'output' => $output,
                'errors' => $errors,
                'status' => $status,
                'command' => $command,
            );
        }
        else{
            return false;
        }
    }


    /**
     * @return array
     */
    private function _getDescriptorSpec(){
        $descriptorsSpec = array(
            0 => array('pipe', 'r'),
        );
        if($this->_output != NULL){
            $descriptorsSpec[1] = array("file", $this->_output, "a");
        }
        else{
            $descriptorsSpec[1] = array('pipe', 'w');
        }
        if($this->_errorsOutput != NULL){
            $descriptorsSpec[2] = array("file", $this->_errorsOutput, "a");
        }
        else{
            $descriptorsSpec[2] = array('pipe', 'w');
        }
        return $descriptorsSpec;
    }

    /**
     * @param null|string $path
     * @return array
     */
    public function getInfo($path = NULL){
        if($path == NULL){
            return array(
                'status' => 2,
                'message' => 'Path not set'
            );
        }
        if(file_exists($path) && is_file($path)){

            $command = $this->_createCommand($path);
            $commandResult = $this->_setCommand($command);
            if($commandResult){
                $result = array_merge(
                    array(
                        'message' => 'File information successfully obtained'
                    ),
                    $commandResult
                );
            }
            else{
                $result = array(
                    'status' => 4,
                    'message' => 'When parsed file '.$path.' error occurred'
                );
            }
        }
        else{
            $result = array(
                'status' => 3,
                'message' => 'File '.$path.' not found'
            );
        }
        return $result;
    }
} 