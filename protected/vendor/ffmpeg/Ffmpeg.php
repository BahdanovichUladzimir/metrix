<?php
/**
 * @author Bahdanovich Uladzimir <bahdanovich.uladzimir@gmail.com>
 * @date: 25.02.14
 */

class Ffmpeg {

    // Main options
    /**
     * @var string|null Путь к Ffmpeg.exe
     */
    private static $_pathToFfmpeg;

    /**
     * @var null|string
     */
    private $_input;

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
    private $_isOverWrite;

    /**
     * @var bool
     */
    private $_isNotOverWrite;

    /**
     * @var null|string
     */
    private $_inputFileFormat;

    /**
     * @var null|string
     */
    private $_outputFileFormat;

    /**
     * @var null|string
     */
    private $_inputCodec;

    /**
     * @var null|string
     */
    private $_inputCodecStreamSpecifier;

    /**
     * @var null|string
     */
    private $_outputCodec;

    /**
     * @var null|string
     */
    private $_outputCodecStreamSpecifier;

    /**
     * @var null|string|int
     */
    private $_stopOutputDuration;

    /**
     * @var null|string|int
     */
    private $_stopOutputPosition;

    /**
     * @var null|string|int
     */
    private $_outputFileSizeLimit;

    /**
     * @var null|string|int
     */
    private $_inputSeekPosition;

    /**
     * @var null|string|int
     */
    private $_outputSeekPosition;

    /**
     * @var null|string
     */
    private $_itsoffset;

    /**
     * @var null|string
     */
    private $_timestamp;

    /**
     * @var null|string
     */
    private $_metadata;

    /**
     * @var null|string
     */
    private $_metadataSpecifier;

    /**
     * @var null|string
     */
    private $_target;

    /**
     * @var null|string|int
     */
    private $_dframes;

    /**
     * @var null|string|int
     */
    private $_frames;

    /**
     * @var null|string
     */
    private $_framesStreamSpecifier;

    /**
     * @var null|string|int
     */
    private $_qscale;

    /**
     * @var null|string
     */
    private $_qscaleStreamSpecifier;

    /**
     * @var null|string
     */
    private $_filter;

    /**
     * @var null|string
     */
    private $_filterStreamSpecifier;

    /**
     * @var null|string
     */
    private $_filterScript;

    /**
     * @var null|string
     */
    private $_filterScriptStreamSpecifier;

    /**
     * @var null|string
     */
    private $_pre;

    /**
     * @var null|string
     */
    private $_preStreamSpecifier;

    /**
     * @var bool
     */
    private $_isStats;

    /**
     * @var bool
     */
    private $_isNoStats;

    /**
     * @var null|string
     */
    private $_progress;

    /**
     * @var bool
     */
    private $_isStdin;

    /**
     * @var bool
     */
    private $_isDebugTs;

    /**
     * @var null|string
     */
    private $_attach;

    /**
     * @var null|string
     */
    private $_dumpAttachment;

    /**
     * @var null|string
     */
    private $_dumpAttachmentStreamSpecifier;


    // Video options
    /**
     * @var null|string|int
     */
    private $_vframes;

    /**
     * @var null|string|int
     */
    private $_inputFrameRate;

    /**
     * @var null|string
     */
    private $_inputFrameRateStreamSpecifier;

    /**
     * @var null|string|int
     */
    private $_outputFrameRate;

    /**
     * @var null|string
     */
    private $_outputFrameRateStreamSpecifier;

    /**
     * @var null|string
     */
    private $_inputSize;

    /**
     * @var null|string
     */
    private $_inputSizeStreamSpecifier;

    /**
     * @var null|string
     */
    private $_outputSize;

    /**
     * @var null|string
     */
    private $_outputSizeStreamSpecifier;

    /**
     * @var null|string|int|float
     */
    private $_aspect;

    /**
     * @var null|string
     */
    private $_aspectStreamSpecifier;

    /**
     * @var bool
     */
    private $_isDisableRecording;

    /**
     * @var null|string
     */
    private $_videoCodec;

    /**
     * @var null|string|int
     */
    private $_pass;

    /**
     * @var null|string
     */
    private $_passStreamSpecifier;

    /**
     * @var null|string
     */
    private $_passLogFile;

    /**
     * @var null|string
     */
    private $_passLogFileStreamSpecifier;

    /**
     * @var null|string
     */
    private $_filterGraph;


    // Advanced video options
    /**
     * @var null|string
     */
    private $_inputPixelFormat;

    /**
     * @var null|string
     */
    private $_inputPixelFormatStreamSpecifier;

    /**
     * @var null|string
     */
    private $_outputPixelFormat;

    /**
     * @var null|string
     */
    private $_outputPixelFormatStreamSpecifier;

    /**
     * @var null|string
     */
    private $_inputSwsFlags;

    /**
     * @var null|string
     */
    private $_outputSwsFlags;

    /**
     * @var null|string|int
     */
    private $_vdt;

    /**
     * @var null|string
     */
    private $_rcOverride;

    /**
     * @var null|string
     */
    private $_rcOverrideStreamSpecifier;

    /**
     * @var bool
     */
    private $_isIlme;

    /**
     * @var bool
     */
    private $_isPsnr;

    /**
     * @var bool
     */
    private $_isVstats;

    /**
     * @var string|null
     */
    private $_vstatsFile;

    /**
     * @var string|null|int
     */
    private $_top;

    /**
     * @var string|null
     */
    private $_topStreamSpecifier;

    /**
     * @var string|null
     */
    private $_intraDcPrecision;

    /**
     * @var string|null
     */
    private $_vtag;

    /**
     * @var bool
     */
    private $_isQPhist;

    /**
     * @var string|null
     */
    private $_forceKeyFrames;

    /**
     * @var string|null
     */
    private $_forceKeyFramesStreamSpecifier;

    /**
     * @var string|null
     */
    private $_copyinkf;

    /**
     * @var string|null
     */
    private $_copyinkfStreamSpecifier;

    /**
     * @var string|null
     */
    private $_hwaccel;

    /**
     * @var string|null
     */
    private $_hwaccelStreamSpecifier;

    /**
     * @var string|null
     */
    private $_hwaccelDevice;

    /**
     * @var string|null
     */
    private $_hwaccelDeviceStreamSpecifier;


    // Audio options

    /**
     * @var string|null|int
     */
    private $_aframes;

    /**
     * @var string|null|int
     */
    private $_inputAr;

    /**
     * @var string|null
     */
    private $_inputArStreamSpecifier;

    /**
     * @var string|null|int
     */
    private $_outputAr;

    /**
     * @var string|null
     */
    private $_outputArStreamSpecifier;

    /**
     * @var string|null
     */
    private $_audioQuality;

    /**
     * @var string|null|int
     */
    private $_inputAudioChannels;

    /**
     * @var string|null
     */
    private $_inputAudioChannelsStreamSpecifier;

    /**
     * @var string|null|int
     */
    private $_outputAudioChannels;

    /**
     * @var string|null
     */
    private $_outputAudioChannelsStreamSpecifier;

    /**
     * @var bool
     */
    private $_isDisabledAudioRecord;

    /**
     * @var string|null
     */
    private $_inputAudioCodec;

    /**
     * @var string|null
     */
    private $_outputAudioCodec;

    /**
     * @var string|null
     */
    private $_sampleFormat;

    /**
     * @var string|null
     */
    private $_sampleFormatStreamSpecifier;

    /**
     * @var string|null
     */
    private $_audioFiltergraph;

    /**
     * @var string|null
     */
    private $_audioTag;

    /**
     * @var string|null|int
     */
    private $_guessLayoutMax;


    // Subtitles settings
    /**
     * @var string|null
     */
    private $_inputSubtitleCodec;

    /**
     * @var string|null
     */
    private $_outputSubtitleCodec;

    /**
     * @var bool
     */
    private $_isDisableSubtitleRecording;

    /**
     * @var bool
     */
    private $_isFixSubDuration;

    /**
     * @var null|string
     */
    private $_canvasSize;

    /**
     * @var bool
     */
    private $_isVersion;

    /**
     * @var null|string
     */
    private $_inputBitRate;

    /**
     * @var null|string
     */
    private $_inputBitRateStreamSpecifier;

    /**
     * @var null|string
     */
    private $_outputBitRate;

    /**
     * @var null|string
     */
    private $_outputBitRateStreamSpecifier;

    /**
     * @var array
     */
    private $_availableFlvAr;

    /**
     * @var int|string|null
     */
    private $_timelimit;


    /**
     * @param string $pathToFfmpeg
     * @throws Exception
     */
    function __construct($pathToFfmpeg = 'ffmpeg'){
        if(!$this->checkFfmpegExist($pathToFfmpeg)){
            throw new Exception("Ffmpeg not found");
        }
        else{
            $this->setPathToFfmpeg($pathToFfmpeg);
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
        $this->_input = NULL;
        $this->_output = NULL;
        $this->_errorsOutput = NULL;
        $this->_cwd = NULL;
        $this->_isOverWrite = false;
        $this->_isNotOverWrite = false;
        $this->_inputFileFormat = NULL;
        $this->_outputFileFormat = NULL;
        $this->_inputCodec = NULL;
        $this->_outputCodec = NULL;
        $this->_stopOutputDuration = NULL;
        $this->_stopOutputPosition = NULL;
        $this->_outputFileSizeLimit = NULL;
        $this->_inputSeekPosition = NULL;
        $this->_outputSeekPosition = NULL;
        $this->_itsoffset = NULL;
        $this->_timestamp = NULL;
        $this->_metadata = NULL;
        $this->_metadataSpecifier = NULL;
        $this->_target = NULL;
        $this->_dframes = NULL;
        $this->_frames = NULL;
        $this->_framesStreamSpecifier = NULL;
        $this->_inputCodecStreamSpecifier = NULL;
        $this->_outputCodecStreamSpecifier = NULL;
        $this->_qscale = NULL;
        $this->_qscaleStreamSpecifier = NULL;
        $this->_filter = NULL;
        $this->_filterStreamSpecifier = NULL;
        $this->_filterScript = NULL;
        $this->_filterScriptStreamSpecifier = NULL;
        $this->_pre = NULL;
        $this->_preStreamSpecifier = NULL;
        $this->_isStats = false;
        $this->_isNoStats = false;
        $this->_progress = NULL;
        $this->_isStdin = false;
        $this->_isDebugTs = false;
        $this->_attach = NULL;
        $this->_dumpAttachment = NULL;
        $this->_dumpAttachmentStreamSpecifier = NULL;
        $this->_vframes = NULL;
        $this->_inputFrameRate = NULL;
        $this->_inputFrameRateStreamSpecifier = NULL;
        $this->_outputFrameRate = NULL;
        $this->_outputFrameRateStreamSpecifier = NULL;
        $this->_inputSize = NULL;
        $this->_inputSizeStreamSpecifier = NULL;
        $this->_outputSize = NULL;
        $this->_outputSizeStreamSpecifier = NULL;
        $this->_aspect = NULL;
        $this->_aspectStreamSpecifier = NULL;
        $this->_isDisableRecording = false;
        $this->_videoCodec = NULL;
        $this->_pass = NULL;
        $this->_passStreamSpecifier = NULL;
        $this->_passLogFile = NULL;
        $this->_passLogFileStreamSpecifier = NULL;
        $this->_filterGraph = NULL;
        $this->_inputPixelFormat = NULL;
        $this->_inputPixelFormatStreamSpecifier = NULL;
        $this->_outputPixelFormat = NULL;
        $this->_outputPixelFormatStreamSpecifier = NULL;
        $this->_inputSwsFlags = NULL;
        $this->_outputSwsFlags = NULL;
        $this->_vdt = NULL;
        $this->_rcOverride = NULL;
        $this->_rcOverrideStreamSpecifier = NULL;
        $this->_isIlme = false;
        $this->_isPsnr = false;
        $this->_isVstats = false;
        $this->_vstatsFile = NULL;
        $this->_top = NULL;
        $this->_topStreamSpecifier = NULL;
        $this->_intraDcPrecision = NULL;
        $this->_vtag = NULL;
        $this->_isQPhist = false;
        $this->_forceKeyFrames = NULL;
        $this->_forceKeyFramesStreamSpecifier = NULL;
        $this->_copyinkf = NULL;
        $this->_copyinkfStreamSpecifier = NULL;
        $this->_hwaccel = NULL;
        $this->_hwaccelStreamSpecifier = NULL;
        $this->_hwaccelDevice = NULL;
        $this->_hwaccelDeviceStreamSpecifier = NULL;
        $this->_aframes = NULL;
        $this->_inputAr = NULL;
        $this->_inputArStreamSpecifier = NULL;
        $this->_outputAr = NULL;
        $this->_outputArStreamSpecifier = NULL;
        $this->_audioQuality = NULL;
        $this->_inputAudioChannels = NULL;
        $this->_inputAudioChannelsStreamSpecifier = NULL;
        $this->_outputAudioChannels = NULL;
        $this->_outputAudioChannelsStreamSpecifier = NULL;
        $this->_isDisabledAudioRecord = false;
        $this->_inputAudioCodec = NULL;
        $this->_outputAudioCodec = NULL;
        $this->_sampleFormat = NULL;
        $this->_sampleFormatStreamSpecifier = NULL;
        $this->_audioFiltergraph = NULL;
        $this->_audioTag = NULL;
        $this->_guessLayoutMax = NULL;
        $this->_inputSubtitleCodec = NULL;
        $this->_outputSubtitleCodec = NULL;
        $this->_isDisableSubtitleRecording = false;
        $this->_isFixSubDuration = false;
        $this->_canvasSize = false;
        $this->_isVersion = false;
        $this->_inputBitRate = false;
        $this->_inputBitRateStreamSpecifier = false;
        $this->_outputBitRate = false;
        $this->_outputBitRateStreamSpecifier = false;
        $this->_availableFlvAr = array(11025,22050,44100);
        $this->_timelimit = NULL;
    }

    /**
     * @param null $path
     * @return string
     */
    public static function setPathToFfmpeg($path = NULL){
        if($path != NULL && is_string($path)){
            $result = self::checkFfmpegExist($path);
            if($result){
                self::$_pathToFfmpeg = $path;
            }
            else{
                self::$_pathToFfmpeg = NULL;
            }
        }
        return $result;
    }

    /**
     * @return string|null
     */
    public static function getPathToFfmpeg(){
        return self::$_pathToFfmpeg;
    }

    /**
     * @param mixed $input
     * @return Ffmpeg
     */
    public function setInput($input = NULL){
        if($input != NULL && is_string($input) && file_exists($input)){
            $this->_input = $input;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInput(){
        return $this->_input;
    }

    /**
     * @param mixed $output
     * @return Ffmpeg
     */
    public function setOutput($output = NULL){
        if($output != NULL && is_string($output)){
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
     * @return Ffmpeg
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
     * @return Ffmpeg
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
     * @param bool $isOverWrite
     * @return Ffmpeg
     */
    public function setIsOverWrite($isOverWrite = true){
        if($isOverWrite){
            $this->_isOverWrite = true;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function getIsOverWrite(){
        return $this->_isOverWrite;
    }

    /**
     * @param boolean $isNotOverWrite
     * @return Ffmpeg
     */
    public function setIsNotOverWrite($isNotOverWrite = true){
        if($isNotOverWrite){
            $this->_isNotOverWrite = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsNotOverWrite(){
        return $this->_isNotOverWrite;
    }

    /**
     * @param null|string $inputFileFormat
     * @return Ffmpeg
     */
    public function setInputFileFormat($inputFileFormat = NULL){
        if($inputFileFormat != NULL && is_string($inputFileFormat)){
            $this->_inputFileFormat = $inputFileFormat;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputFileFormat(){
        return $this->_inputFileFormat;
    }

    /**
     * @param null|string $outputFileFormat
     * @return Ffmpeg
     */
    public function setOutputFileFormat($outputFileFormat = NULL){
        if($outputFileFormat != NULL && is_string($outputFileFormat)){
            $this->_outputFileFormat = $outputFileFormat;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputFileFormat(){
        return $this->_outputFileFormat;
    }

    /**
     * @param null|string $inputCodec
     * @return Ffmpeg
     */
    public function setInputCodec($inputCodec = NULL){
        if($inputCodec != NULL && is_string($inputCodec)){
            $this->_inputCodec = $inputCodec;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputCodec(){
        return $this->_inputCodec;
    }

    /**
     * @param null|string $outputCodec
     * @return Ffmpeg
     */
    public function setOutputCodec($outputCodec = NULL){
        if($outputCodec != NULL && is_string($outputCodec)){
            $this->_outputCodec = $outputCodec;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputCodec(){
        return $this->_outputCodec;
    }

    /**
     * @param null|string|int $stopOutputDuration
     * @return Ffmpeg
     */
    public function setStopOutputDuration($stopOutputDuration = NULL){
        $sod = $stopOutputDuration;
        if($sod != NULL && (is_string($sod) || is_int($sod))){
            $this->_stopOutputDuration = $sod;
        }
        return $this;
    }

    /**
     * @return null|string|int
     */
    public function getStopOutputDuration(){
        return $this->_stopOutputDuration;
    }

    /**
     * @param null|string|int $stopOutputPosition
     * @return Ffmpeg
     */
    public function setStopOutputPosition($stopOutputPosition = NULL){
        $sop = $stopOutputPosition;
        if($sop != NULL && (is_string($sop) || is_int($sop))){
            $this->_stopOutputPosition = $sop;
        }
        return $this;
    }

    /**
     * @return null|string|int
     */
    public function getStopOutputPosition(){
        return $this->_stopOutputPosition;
    }

    /**
     * @param int|null|string $outputFileSizeLimit
     * @return Ffmpeg
     */
    public function setOutputFileSizeLimit($outputFileSizeLimit = NULL){
        $fs = $outputFileSizeLimit;
        if($fs != NULL && (is_string($fs) || is_int($fs))){
            $this->_outputFileSizeLimit = $fs;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getOutputFileSizeLimit(){
        return $this->_outputFileSizeLimit;
    }

    /**
     * @param null|string|int $inputSeekPosition
     * @return Ffmpeg
     */
    public function setInputSeekPosition($inputSeekPosition = NULL){
        $isp = $inputSeekPosition;
        if($isp != NULL && (is_string($isp) || is_int($isp))){
            $this->_inputSeekPosition = $isp;
        }
        return $this;
    }

    /**
     * @return null|string|int
     */
    public function getInputSeekPosition(){
        return $this->_inputSeekPosition;
    }

    /**
     * @param null|string|int $outputSeekPosition
     * @return Ffmpeg
     */
    public function setOutputSeekPosition($outputSeekPosition = NULL){
        $osp = $outputSeekPosition;
        if($osp != NULL && (is_string($osp) || is_int($osp))){
            $this->_outputSeekPosition = $osp;
        }
        return $this;
    }

    /**
     * @return null|string|int
     */
    public function getOutputSeekPosition(){
        return $this->_outputSeekPosition;
    }

    /**
     * @param null|string $itsoffset
     * @return Ffmpeg
     */
    public function setItsoffset($itsoffset = NULL){
        if($itsoffset != NULL && is_string($itsoffset)) {
            $this->_itsoffset = $itsoffset;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getItsoffset(){
        return $this->_itsoffset;
    }

    /**
     * @param null|string $timestamp
     * @return Ffmpeg
     */
    public function setTimestamp($timestamp = NULL){
        if($timestamp != NULL && is_string($timestamp)){
            $this->_timestamp = $timestamp;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTimestamp(){
        return $this->_timestamp;
    }

    /**
     * @param null|string $metadata
     * @return Ffmpeg
     */
    public function setMetadata($metadata = NULL){
        if ($metadata != NULL && is_string($metadata)) {
            $this->_metadata = $metadata;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMetadata(){
        return $this->_metadata;
    }

    /**
     * @param null|string $metadataSpecifier
     * @return Ffmpeg
     */
    public function setMetadataSpecifier($metadataSpecifier = NULL){
        if ($metadataSpecifier != NULL && is_string($metadataSpecifier)) {
            $this->_metadataSpecifier = $metadataSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getMetadataSpecifier(){
        return $this->_metadataSpecifier;
    }

    /**
     * @param null|string $target
     * @return Ffmpeg
     */
    public function setTarget($target = NULL){
        if ($target != NULL && is_string($target)) {
            $this->_target = $target;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTarget(){
        return $this->_target;
    }

    /**
     * @param null|string|int $dFrames
     * @return Ffmpeg
     */
    public function setDframes($dFrames = NULL){
        $df = $dFrames;
        if($df != NULL && (is_string($df) || is_int($df))){
            $this->_dframes = $df;
        }
        return $this;
    }

    /**
     * @return null|string|int
     */
    public function getDframes(){
        return $this->_dframes;
    }

    /**
     * @param null|string|int $frames
     * @return Ffmpeg
     */
    public function setFrames($frames = NULL){
        $f = $frames;
        if($f != NULL && (is_string($f) || is_int($f))){
            $this->_frames = $f;
        }
        return $this;
    }

    /**
     * @return null|string|int
     */
    public function getFrames(){
        return $this->_frames;
    }

    /**
     * @param null|string $framesStreamSpecifier
     * @return Ffmpeg
     */
    public function setFramesStreamSpecifier($framesStreamSpecifier = NULL){
        if ($framesStreamSpecifier != NULL && is_string($framesStreamSpecifier)) {
            $this->_framesStreamSpecifier = $framesStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFramesStreamSpecifier(){
        return $this->_framesStreamSpecifier;
    }

    /**
     * @param null|string $inputCodecStreamSpecifier
     * @return Ffmpeg
     */
    public function setInputCodecStreamSpecifier($inputCodecStreamSpecifier = NULL){
        if ($inputCodecStreamSpecifier != NULL && is_string($inputCodecStreamSpecifier)) {
            $this->_inputCodecStreamSpecifier = $inputCodecStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputCodecStreamSpecifier(){
        return $this->_inputCodecStreamSpecifier;
    }

    /**
     * @param null|string $outputCodecStreamSpecifier
     * @return Ffmpeg
     */
    public function setOutputCodecStreamSpecifier($outputCodecStreamSpecifier = NULL){
        if ($outputCodecStreamSpecifier != NULL && is_string($outputCodecStreamSpecifier)) {
            $this->_outputCodecStreamSpecifier = $outputCodecStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputCodecStreamSpecifier(){
        return $this->_outputCodecStreamSpecifier;
    }

    /**
     * @param int|null|string $qscale
     * @return Ffmpeg
     */
    public function setQscale($qscale = NULL){
        if ($qscale != NULL && (is_string($qscale) || is_int($qscale))) {
            $this->_qscale = $qscale;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getQscale(){
        return $this->_qscale;
    }

    /**
     * @param null|string $qscaleStreamSpecifier
     * @return Ffmpeg
     */
    public function setQscaleStreamSpecifier($qscaleStreamSpecifier = NULL){
        if ($qscaleStreamSpecifier != NULL && is_string($qscaleStreamSpecifier)) {
            $this->_qscaleStreamSpecifier = $qscaleStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getQscaleStreamSpecifier(){
        return $this->_qscaleStreamSpecifier;
    }

    /**
     * @param null|string $filter
     * @return Ffmpeg
     */
    public function setFilter($filter = NULL){
        if ($filter != NULL && is_string($filter)) {
            $this->_filter = $filter;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFilter(){
        return $this->_filter;
    }

    /**
     * @param null|string $filterStreamSpecifier
     * @return Ffmpeg
     */
    public function setFilterStreamSpecifier($filterStreamSpecifier = NULL){
        if ($filterStreamSpecifier != NULL && is_string($filterStreamSpecifier)) {
            $this->_filterStreamSpecifier = $filterStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFilterStreamSpecifier(){
        return $this->_filterStreamSpecifier;
    }

    /**
     * @param null|string $filterScript
     * @return Ffmpeg
     */
    public function setFilterScript($filterScript = NULL){
        if ($filterScript != NULL && is_string($filterScript) && file_exists($filterScript)) {
            $this->_filterScript = $filterScript;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFilterScript(){
        return $this->_filterScript;
    }

    /**
     * @param null|string $filterScriptStreamSpecifier
     * @return Ffmpeg
     */
    public function setFilterScriptStreamSpecifier($filterScriptStreamSpecifier = NULL){
        if ($filterScriptStreamSpecifier != NULL && is_string($filterScriptStreamSpecifier)) {
            $this->_filterScriptStreamSpecifier = $filterScriptStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFilterScriptStreamSpecifier(){
        return $this->_filterScriptStreamSpecifier;
    }

    /**
     * @param null|string $pre
     * @return Ffmpeg
     */
    public function setPre($pre = NULL){
        if ($pre != NULL && is_string($pre)) {
            $this->_pre = $pre;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPre(){
        return $this->_pre;
    }

    /**
     * @param null|string $preStreamSpecifier
     * @return Ffmpeg
     */
    public function setPreStreamSpecifier($preStreamSpecifier = NULL){
        if ($preStreamSpecifier != NULL && is_string($preStreamSpecifier)) {
            $this->_preStreamSpecifier = $preStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPreStreamSpecifier(){
        return $this->_preStreamSpecifier;
    }

    /**
     * @param boolean $stats
     * @return Ffmpeg
     */
    public function setIsStats($stats = true){
        if ($stats) {
            $this->_isStats = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsStats(){
        return $this->_isStats;
    }

    /**
     * @param boolean $noStats
     * @return Ffmpeg
     */
    public function setIsNoStats($noStats = true){
        if ($noStats) {
            $this->_isNoStats = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsNoStats(){
        return $this->_isNoStats;
    }

    /**
     * @param boolean $stdin
     * @return Ffmpeg
     */
    public function setIsStdin($stdin = true){
        if ($stdin) {
            $this->_isStdin = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsStdin(){
        return $this->_isStdin;
    }

    /**
     * @param boolean $debugTs
     * @return Ffmpeg
     */
    public function setIsDebugTs($debugTs = true){
        if ($debugTs) {
            $this->_isDebugTs = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsDebugTs(){
        return $this->_isDebugTs;
    }

    /**
     * @param null|string $progress
     * @return Ffmpeg
     */
    public function setProgress($progress = NULL){
        if ($progress != NULL && is_string($progress)) {
            $this->_progress = $progress;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getProgress(){
        return $this->_progress;
    }

    /**
     * @param null|string $attach
     * @return Ffmpeg
     */
    public function setAttach($attach = NULL){
        if ($attach != NULL && is_string($attach) && file_exists($attach)) {
            $this->_attach = $attach;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAttach(){
        return $this->_attach;
    }

    /**
     * @param null|string $dumpAttachment
     * @return Ffmpeg
     */
    public function setDumpAttachment($dumpAttachment = NULL){
        if ($dumpAttachment != NULL && is_string($dumpAttachment) && file_exists($dumpAttachment)) {
            $this->_dumpAttachment = $dumpAttachment;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDumpAttachment(){
        return $this->_dumpAttachment;
    }

    /**
     * @param null|string $dumpAttachmentStreamSpecifier
     * @return Ffmpeg
     */
    public function setDumpAttachmentStreamSpecifier($dumpAttachmentStreamSpecifier = NULL){
        if ($dumpAttachmentStreamSpecifier != NULL && is_string($dumpAttachmentStreamSpecifier)) {
            $this->_dumpAttachmentStreamSpecifier = $dumpAttachmentStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getDumpAttachmentStreamSpecifier(){
        return $this->_dumpAttachmentStreamSpecifier;
    }

    /**
     * @param int|null|string $vframes
     * @return Ffmpeg
     */
    public function setVframes($vframes = NULL){
        if ($vframes != NULL && (is_string($vframes) || is_int($vframes))) {
            $this->_vframes = $vframes;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getVframes(){
        return $this->_vframes;
    }

    /**
     * @param int|null|string $inputFrameRate
     * @return Ffmpeg
     */
    public function setInputFrameRate($inputFrameRate = NULL){
        if ($inputFrameRate != NULL && (is_string($inputFrameRate) || is_float($inputFrameRate) || is_int($inputFrameRate))) {
            $this->_inputFrameRate = $inputFrameRate;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getInputFrameRate(){
        return $this->_inputFrameRate;
    }

    /**
     * @param null|string $inputFrameRateStreamSpecifier
     * @return Ffmpeg
     */
    public function setInputFrameRateStreamSpecifier($inputFrameRateStreamSpecifier = NULL){
        if ($inputFrameRateStreamSpecifier != NULL && is_string($inputFrameRateStreamSpecifier)) {
            $this->_inputFrameRateStreamSpecifier = $inputFrameRateStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputFrameRateStreamSpecifier(){
        return $this->_inputFrameRateStreamSpecifier;
    }

    /**
     * @param int|null|string $outputFrameRate
     * @return Ffmpeg
     */
    public function setOutputFrameRate($outputFrameRate = NULL){
        if ($outputFrameRate != NULL && (is_string($outputFrameRate) || is_float($outputFrameRate) || is_int($outputFrameRate))) {
            $this->_outputFrameRate = $outputFrameRate;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getOutputFrameRate(){
        return $this->_outputFrameRate;
    }

    /**
     * @param null|string $outputFrameRateStreamSpecifier
     * @return Ffmpeg
     */
    public function setOutputFrameRateStreamSpecifier($outputFrameRateStreamSpecifier = NULL){
        if ($outputFrameRateStreamSpecifier != NULL && is_string($outputFrameRateStreamSpecifier)) {
            $this->_outputFrameRateStreamSpecifier = $outputFrameRateStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputFrameRateStreamSpecifier(){
        return $this->_outputFrameRateStreamSpecifier;
    }

    /**
     * @param null|string $inputSize
     * @return Ffmpeg
     */
    public function setInputSize($inputSize = NULL){
        if ($inputSize != NULL && is_string($inputSize)) {
            $this->_inputSize = $inputSize;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputSize(){
        return $this->_inputSize;
    }

    /**
     * @param null|string $inputSizeStreamSpecifier
     * @return Ffmpeg
     */
    public function setInputSizeStreamSpecifier($inputSizeStreamSpecifier = NULL){
        if ($inputSizeStreamSpecifier != NULL && is_string($inputSizeStreamSpecifier)) {
            $this->_inputSizeStreamSpecifier = $inputSizeStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputSizeStreamSpecifier(){
        return $this->_inputSizeStreamSpecifier;
    }

    /**
     * @param null|string $outputSize
     * @return Ffmpeg
     */
    public function setOutputSize($outputSize = NULL){
        if ($outputSize != NULL && is_string($outputSize)) {
            $this->_outputSize = $outputSize;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputSize(){
        return $this->_outputSize;
    }

    /**
     * @param null|string $outputSizeStreamSpecifier
     * @return Ffmpeg
     */
    public function setOutputSizeStreamSpecifier($outputSizeStreamSpecifier = NULL){
        if ($outputSizeStreamSpecifier != NULL && is_string($outputSizeStreamSpecifier)) {
            $this->_outputSizeStreamSpecifier = $outputSizeStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputSizeStreamSpecifier(){
        return $this->_outputSizeStreamSpecifier;
    }

    /**
     * @param float|int|null|string $aspect
     * @return Ffmpeg
     */
    public function setAspect($aspect = NULL){
        if ($aspect != NULL && (is_string($aspect) || is_float($aspect) || is_int($aspect))) {
            $this->_aspect = $aspect;
        }
        return $this;
    }

    /**
     * @return float|int|null|string
     */
    public function getAspect(){
        return $this->_aspect;
    }

    /**
     * @param null|string $aspectStreamSpecifier
     * @return Ffmpeg
     */
    public function setAspectStreamSpecifier($aspectStreamSpecifier = NULL){
        if ($aspectStreamSpecifier != NULL && is_string($aspectStreamSpecifier)) {
            $this->_aspectStreamSpecifier = $aspectStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAspectStreamSpecifier(){
        return $this->_aspectStreamSpecifier;
    }

    /**
     * @param boolean $isDisableRecording
     * @return Ffmpeg
     */
    public function setIsDisableRecording($isDisableRecording = true){
        if ($isDisableRecording) {
            $this->_isDisableRecording = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsDisableRecording(){
        return $this->_isDisableRecording;
    }

    /**
     * @param null|string $videoCodec
     * @return Ffmpeg
     */
    public function setVideoCodec($videoCodec = NULL){
        if ($videoCodec != NULL && is_string($videoCodec)) {
            $this->_videoCodec = $videoCodec;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVideoCodec(){
        return $this->_videoCodec;
    }

    /**
     * @param int|null|string $pass
     * @return Ffmpeg
     */
    public function setPass($pass = NULL){
        if ($pass != NULL && (is_string($pass) || is_int($pass))) {
            $this->_pass = $pass;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getPass(){
        return $this->_pass;
    }

    /**
     * @param null|string $passStreamSpecifier
     * @return Ffmpeg
     */
    public function setPassStreamSpecifier($passStreamSpecifier = NULL){
        if ($passStreamSpecifier != NULL && is_string($passStreamSpecifier)) {
            $this->_passStreamSpecifier = $passStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassStreamSpecifier(){
        return $this->_passStreamSpecifier;
    }

    /**
     * @param null|string $passLogFile
     * @return Ffmpeg
     */
    public function setPassLogFile($passLogFile = NULL){
        if ($passLogFile != NULL && is_string($passLogFile)) {
            $this->_passLogFile = $passLogFile;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassLogFile(){
        return $this->_passLogFile;
    }

    /**
     * @param null|string $passLogFileStreamSpecifier
     * @return Ffmpeg
     */
    public function setPassLogFileStreamSpecifier($passLogFileStreamSpecifier = NULL){
        if ($passLogFileStreamSpecifier != NULL && is_string($passLogFileStreamSpecifier)) {
            $this->_passLogFileStreamSpecifier = $passLogFileStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassLogFileStreamSpecifier(){
        return $this->_passLogFileStreamSpecifier;
    }

    /**
     * @param null|string $filterGraph
     * @return Ffmpeg
     */
    public function setFilterGraph($filterGraph = NULL){
        if ($filterGraph != NULL && is_string($filterGraph)) {
            $this->_filterGraph = $filterGraph;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getFilterGraph(){
        return $this->_filterGraph;
    }

    /**
     * @param null|string $inputPixelFormat
     * @return Ffmpeg
     */
    public function setInputPixelFormat($inputPixelFormat = NULL){
        if ($inputPixelFormat != NULL && is_string($inputPixelFormat)) {
            $this->_inputPixelFormat = $inputPixelFormat;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputPixelFormat(){
        return $this->_inputPixelFormat;
    }

    /**
     * @param null|string $inputPixelFormatStreamSpecifier
     * @return Ffmpeg
     */
    public function setInputPixelFormatStreamSpecifier($inputPixelFormatStreamSpecifier = NULL){
        if ($inputPixelFormatStreamSpecifier != NULL && is_string($inputPixelFormatStreamSpecifier)) {
            $this->_inputPixelFormatStreamSpecifier = $inputPixelFormatStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputPixelFormatStreamSpecifier(){
        return $this->_inputPixelFormatStreamSpecifier;
    }

    /**
     * @param null|string $outputPixelFormat
     * @return Ffmpeg
     */
    public function setOutputPixelFormat($outputPixelFormat = NULL){
        if ($outputPixelFormat != NULL && is_string($outputPixelFormat)) {
            $this->_outputPixelFormat = $outputPixelFormat;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputPixelFormat(){
        return $this->_outputPixelFormat;
    }

    /**
     * @param null|string $outputPixelFormatStreamSpecifier
     * @return Ffmpeg
     */
    public function setOutputPixelFormatStreamSpecifier($outputPixelFormatStreamSpecifier = NULL){
        if ($outputPixelFormatStreamSpecifier != NULL && is_string($outputPixelFormatStreamSpecifier)) {
            $this->_outputPixelFormatStreamSpecifier = $outputPixelFormatStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputPixelFormatStreamSpecifier(){
        return $this->_outputPixelFormatStreamSpecifier;
    }

    /**
     * @param null|string $inputSwsFlags
     * @return Ffmpeg
     */
    public function setInputSwsFlags($inputSwsFlags = NULL){
        if ($inputSwsFlags != NULL && is_string($inputSwsFlags)) {
            $this->_inputSwsFlags = $inputSwsFlags;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputSwsFlags(){
        return $this->_inputSwsFlags;
    }

    /**
     * @param null|string $outputSwsFlags
     * @return Ffmpeg
     */
    public function setOutputSwsFlags($outputSwsFlags = NULL){
        if ($outputSwsFlags != NULL && is_string($outputSwsFlags)) {
            $this->_outputSwsFlags = $outputSwsFlags;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputSwsFlags(){
        return $this->_outputSwsFlags;
    }

    /**
     * @param int|null|string $vdt
     * @return Ffmpeg
     */
    public function setVdt($vdt = NULL){
        if ($vdt != NULL && (is_string($vdt) || is_int($vdt))) {
            $this->_vdt = $vdt;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getVdt(){
        return $this->_vdt;
    }

    /**
     * @param null|string $rcOverride
     * @return Ffmpeg
     */
    public function setRcOverride($rcOverride = NULL){
        if ($rcOverride != NULL && is_string($rcOverride)) {
            $this->_rcOverride = $rcOverride;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getRcOverride(){
        return $this->_rcOverride;
    }

    /**
     * @param null|string $rcOverrideStreamSpecifier
     * @return Ffmpeg
     */
    public function setRcOverrideStreamSpecifier($rcOverrideStreamSpecifier = NULL){
        if ($rcOverrideStreamSpecifier != NULL && is_string($rcOverrideStreamSpecifier)) {
            $this->_rcOverrideStreamSpecifier = $rcOverrideStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getRcOverrideStreamSpecifier(){
        return $this->_rcOverrideStreamSpecifier;
    }

    /**
     * @param boolean $ilme
     * @return Ffmpeg
     */
    public function setIsIlme($ilme = true){
        if ($ilme) {
            $this->_isIlme = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsIlme(){
        return $this->_isIlme;
    }

    /**
     * @param boolean $psnr
     * @return Ffmpeg
     */
    public function setIsPsnr($psnr = true){
        if ($psnr) {
            $this->_isPsnr = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsPsnr(){
        return $this->_isPsnr;
    }

    /**
     * @param boolean $vstats
     * @return Ffmpeg
     */
    public function setIsVstats($vstats = true){
        if ($vstats) {
            $this->_isVstats = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsVstats(){
        return $this->_isVstats;
    }

    /**
     * @param null|string $vstatsFile
     * @return Ffmpeg
     */
    public function setVstatsFile($vstatsFile = NULL){
        if ($vstatsFile != NULL && is_string($vstatsFile) && file_exists($vstatsFile)) {
            $this->_vstatsFile = $vstatsFile;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVstatsFile(){
        return $this->_vstatsFile;
    }

    /**
     * @param null|string $top
     * @return Ffmpeg
     */
    public function setTop($top = NULL){
        if ($top != NULL && (is_string($top) || is_int($top))) {
            $this->_top = $top;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTop(){
        return $this->_top;
    }

    /**
     * @param null|string $topStreamSpecifier
     * @return Ffmpeg
     */
    public function setTopStreamSpecifier($topStreamSpecifier = NULL){
        if ($topStreamSpecifier != NULL && is_string($topStreamSpecifier)) {
            $this->_topStreamSpecifier = $topStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTopStreamSpecifier(){
        return $this->_topStreamSpecifier;
    }

    /**
     * @param null|string $intraDcPrecision
     * @return Ffmpeg
     */
    public function setIntraDcPrecision($intraDcPrecision = NULL){
        if ($intraDcPrecision != NULL && is_string($intraDcPrecision)) {
            $this->_intraDcPrecision = $intraDcPrecision;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getIntraDcPrecision(){
        return $this->_intraDcPrecision;
    }

    /**
     * @param null|string $vtag
     * @return Ffmpeg
     */
    public function setVtag($vtag = NULL){
        if ($vtag != NULL && is_string($vtag)) {
            $this->_vtag = $vtag;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getVtag(){
        return $this->_vtag;
    }

    /**
     * @param boolean $isQP
     * @return Ffmpeg
     */
    public function setIsQPhist($isQP = true){
        if ($isQP) {
            $this->_isQPhist = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsQPhist(){
        return $this->_isQPhist;
    }

    /**
     * @param null|string $forceKeyFrames
     * @return Ffmpeg
     */
    public function setForceKeyFrames($forceKeyFrames = NULL){
        if ($forceKeyFrames != NULL && is_string($forceKeyFrames)) {
            $this->_forceKeyFrames = $forceKeyFrames;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getForceKeyFrames(){
        return $this->_forceKeyFrames;
    }

    /**
     * @param null|string $forceKeyFramesStreamSpecifier
     * @return Ffmpeg
     */
    public function setForceKeyFramesStreamSpecifier($forceKeyFramesStreamSpecifier = NULL){
        if ($forceKeyFramesStreamSpecifier != NULL && is_string($forceKeyFramesStreamSpecifier)) {
            $this->_forceKeyFramesStreamSpecifier = $forceKeyFramesStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getForceKeyFramesStreamSpecifier(){
        return $this->_forceKeyFramesStreamSpecifier;
    }

    /**
     * @param null|string $copyinkf
     * @return Ffmpeg
     */
    public function setCopyinkf($copyinkf = NULL){
        if ($copyinkf != NULL && is_string($copyinkf)) {
            $this->_copyinkf = $copyinkf;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCopyinkf(){
        return $this->_copyinkf;
    }

    /**
     * @param null|string $copyinkfStreamSpecifier
     * @return Ffmpeg
     */
    public function setCopyinkfStreamSpecifier($copyinkfStreamSpecifier = NULL){
        if ($copyinkfStreamSpecifier != NULL && is_string($copyinkfStreamSpecifier)) {
            $this->_copyinkfStreamSpecifier = $copyinkfStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCopyinkfStreamSpecifier(){
        return $this->_copyinkfStreamSpecifier;
    }

    /**
     * @param null|string $hwaccel
     * @return Ffmpeg
     */
    public function setHwaccel($hwaccel = NULL){
        if ($hwaccel != NULL && is_string($hwaccel)) {
            $this->_hwaccel = $hwaccel;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getHwaccel(){
        return $this->_hwaccel;
    }

    /**
     * @param null|string $hwaccelStreamSpecifier
     * @return Ffmpeg
     */
    public function setHwaccelStreamSpecifier($hwaccelStreamSpecifier = NULL){
        if ($hwaccelStreamSpecifier != NULL && is_string($hwaccelStreamSpecifier)) {
            $this->_hwaccelStreamSpecifier = $hwaccelStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getHwaccelStreamSpecifier(){
        return $this->_hwaccelStreamSpecifier;
    }

    /**
     * @param null|string $hwaccelDevice
     * @return Ffmpeg
     */
    public function setHwaccelDevice($hwaccelDevice = NULL){
        if ($hwaccelDevice != NULL && is_string($hwaccelDevice)) {
            $this->_hwaccelDevice = $hwaccelDevice;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getHwaccelDevice(){
        return $this->_hwaccelDevice;
    }

    /**
     * @param null|string $hwaccelDeviceStreamSpecifier
     * @return Ffmpeg
     */
    public function setHwaccelDeviceStreamSpecifier($hwaccelDeviceStreamSpecifier = NULL){
        if ($hwaccelDeviceStreamSpecifier != NULL && is_string($hwaccelDeviceStreamSpecifier)) {
            $this->_hwaccelDeviceStreamSpecifier = $hwaccelDeviceStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getHwaccelDeviceStreamSpecifier(){
        return $this->_hwaccelDeviceStreamSpecifier;
    }

    /**
     * @param int|null|string $aframes
     * @return Ffmpeg
     */
    public function setAframes($aframes = NULL){
        if ($aframes != NULL && (is_string($aframes) || is_int($aframes))) {
            $this->_aframes = $aframes;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getAframes(){
        return $this->_aframes;
    }

    /**
     * @param int|null|string $inputAr
     * @return Ffmpeg
     */
    public function setInputAr($inputAr = NULL){
        if ($inputAr != NULL && (is_string($inputAr) || is_int($inputAr))) {
            $this->_inputAr = $inputAr;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getInputAr(){
        return $this->_inputAr;
    }

    /**
     * @param null|string $inputArStreamSpecifier
     * @return Ffmpeg
     */
    public function setInputArStreamSpecifier($inputArStreamSpecifier = NULL){
        if ($inputArStreamSpecifier != NULL && is_string($inputArStreamSpecifier)) {
            $this->_inputArStreamSpecifier = $inputArStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputArStreamSpecifier(){
        return $this->_inputArStreamSpecifier;
    }

    /**
     * @param int|null|string $outputAr
     * @return Ffmpeg
     */
    public function setOutputAr($outputAr = NULL){
        if ($outputAr != NULL && (is_string($outputAr) || is_int($outputAr))) {
            $this->_outputAr = $outputAr;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getOutputAr(){
        return $this->_outputAr;
    }

    /**
     * @param null|string $outputArStreamSpecifier
     * @return Ffmpeg
     */
    public function setOutputArStreamSpecifier($outputArStreamSpecifier = NULL){
        if ($outputArStreamSpecifier != NULL && is_string($outputArStreamSpecifier)) {
            $this->_outputArStreamSpecifier = $outputArStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputArStreamSpecifier(){
        return $this->_outputArStreamSpecifier;
    }

    /**
     * @param null|string $audioQuality
     * @return Ffmpeg
     */
    public function setAudioQuality($audioQuality = NULL){
        if ($audioQuality != NULL && is_string($audioQuality)) {
            $this->_audioQuality = $audioQuality;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAudioQuality(){
        return $this->_audioQuality;
    }

    /**
     * @param int|null|string $inputAudioChannels
     * @return Ffmpeg
     */
    public function setInputAudioChannels($inputAudioChannels = NULL){
        if ($inputAudioChannels != NULL && (is_string($inputAudioChannels) || is_int($inputAudioChannels))) {
            $this->_inputAudioChannels = $inputAudioChannels;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getInputAudioChannels(){
        return $this->_inputAudioChannels;
    }

    /**
     * @param null|string $inputAudioChannelsStreamSpecifier
     * @return Ffmpeg
     */
    public function setInputAudioChannelsStreamSpecifier($inputAudioChannelsStreamSpecifier = NULL){
        if ($inputAudioChannelsStreamSpecifier != NULL && is_string($inputAudioChannelsStreamSpecifier)) {
            $this->_inputAudioChannelsStreamSpecifier = $inputAudioChannelsStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputAudioChannelsStreamSpecifier(){
        return $this->_inputAudioChannelsStreamSpecifier;
    }

    /**
     * @param int|null|string $outputAudioChannels
     * @return Ffmpeg
     */
    public function setOutputAudioChannels($outputAudioChannels = NULL){
        if ($outputAudioChannels != NULL && (is_string($outputAudioChannels)) || is_int($outputAudioChannels)) {
            $this->_outputAudioChannels = $outputAudioChannels;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getOutputAudioChannels(){
        return $this->_outputAudioChannels;
    }

    /**
     * @param null|string $outputAudioChannelsStreamSpecifier
     * @return Ffmpeg
     */
    public function setOutputAudioChannelsStreamSpecifier($outputAudioChannelsStreamSpecifier = NULL){
        if ($outputAudioChannelsStreamSpecifier != NULL && is_string($outputAudioChannelsStreamSpecifier)) {
            $this->_outputAudioChannelsStreamSpecifier = $outputAudioChannelsStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputAudioChannelsStreamSpecifier(){
        return $this->_outputAudioChannelsStreamSpecifier;
    }

    /**
     * @param boolean $isDisabledAudioRecord
     * @return Ffmpeg
     */
    public function setIsDisabledAudioRecord($isDisabledAudioRecord = true){
        if ($isDisabledAudioRecord) {
            $this->_isDisabledAudioRecord = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsDisabledAudioRecord(){
        return $this->_isDisabledAudioRecord;
    }

    /**
     * @param null|string $inputAudioCodec
     * @return Ffmpeg
     */
    public function setInputAudioCodec($inputAudioCodec = NULL){
        if ($inputAudioCodec != NULL && is_string($inputAudioCodec)) {
            $this->_inputAudioCodec = $inputAudioCodec;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputAudioCodec(){
        return $this->_inputAudioCodec;
    }

    /**
     * @param null|string $outputAudioCodec
     * @return Ffmpeg
     */
    public function setOutputAudioCodec($outputAudioCodec = NULL){
        if ($outputAudioCodec != NULL && is_string($outputAudioCodec)) {
            $this->_outputAudioCodec = $outputAudioCodec;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputAudioCodec(){
        return $this->_outputAudioCodec;
    }

    /**
     * @param null|string $sampleFormat
     * @return Ffmpeg
     */
    public function setSampleFormat($sampleFormat = NULL){
        if ($sampleFormat != NULL && is_string($sampleFormat)) {
            $this->_sampleFormat = $sampleFormat;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSampleFormat(){
        return $this->_sampleFormat;
    }

    /**
     * @param null|string $sampleFormatStreamSpecifier
     * @return Ffmpeg
     */
    public function setSampleFormatStreamSpecifier($sampleFormatStreamSpecifier = NULL){
        if ($sampleFormatStreamSpecifier != NULL && is_string($sampleFormatStreamSpecifier)) {
            $this->_sampleFormatStreamSpecifier = $sampleFormatStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getSampleFormatStreamSpecifier(){
        return $this->_sampleFormatStreamSpecifier;
    }

    /**
     * @param null|string $audioFiltergraph
     * @return Ffmpeg
     */
    public function setAudioFiltergraph($audioFiltergraph = NULL){
        if ($audioFiltergraph != NULL && is_string($audioFiltergraph)) {
            $this->_audioFiltergraph = $audioFiltergraph;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAudioFiltergraph(){
        return $this->_audioFiltergraph;
    }

    /**
     * @param null|string $audioTag
     * @return Ffmpeg
     */
    public function setAudioTag($audioTag = NULL){
        if ($audioTag != NULL && is_string($audioTag)) {
            $this->_audioTag = $audioTag;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAudioTag(){
        return $this->_audioTag;
    }

    /**
     * @param int|null|string $guessLayoutMax
     * @return Ffmpeg
     */
    public function setGuessLayoutMax($guessLayoutMax = NULL){
        if ($guessLayoutMax != NULL && (is_string($guessLayoutMax)) || is_int($guessLayoutMax)) {
            $this->_guessLayoutMax = $guessLayoutMax;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getGuessLayoutMax(){
        return $this->_guessLayoutMax;
    }

    /**
     * @param null|string $inputSubtitleCodec
     * @return Ffmpeg
     */
    public function setInputSubtitleCodec($inputSubtitleCodec = NULL){
        if ($inputSubtitleCodec != NULL && is_string($inputSubtitleCodec)) {
            $this->_inputSubtitleCodec = $inputSubtitleCodec;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputSubtitleCodec(){
        return $this->_inputSubtitleCodec;
    }

    /**
     * @param null|string $outputSubtitleCodec
     * @return Ffmpeg
     */
    public function setOutputSubtitleCodec($outputSubtitleCodec = NULL){
        if ($outputSubtitleCodec != NULL && is_string($outputSubtitleCodec)) {
            $this->_outputSubtitleCodec = $outputSubtitleCodec;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputSubtitleCodec(){
        return $this->_outputSubtitleCodec;
    }

    /**
     * @param boolean $isDisableSubtitleRecording
     * @return Ffmpeg
     */
    public function setIsDisableSubtitleRecording($isDisableSubtitleRecording = true){
        if ($isDisableSubtitleRecording) {
            $this->_isDisableSubtitleRecording = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsDisableSubtitleRecording(){
        return $this->_isDisableSubtitleRecording;
    }

    /**
     * @param boolean $isFixSubDuration
     * @return Ffmpeg
     */
    public function setIsFixSubDuration($isFixSubDuration = true){
        if ($isFixSubDuration) {
            $this->_isFixSubDuration = true;
        }
        return $this;
    }

    /**
     * @return boolean
     */
    public function getIsFixSubDuration(){
        return $this->_isFixSubDuration;
    }

    /**
     * @param null|string $canvasSize
     * @return Ffmpeg
     */
    public function setCanvasSize($canvasSize = NULL){
        if ($canvasSize != NULL && is_string($canvasSize)) {
            $this->_canvasSize = $canvasSize;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCanvasSize(){
        return $this->_canvasSize;
    }

    /**
     * @param bool $isVersion
     * @return Ffmpeg
     */
    public function setIsVersion($isVersion = true){
        if ($isVersion) {
            $this->_isVersion = $isVersion;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getIsVersion(){
        return $this->_isVersion;
    }

    /**
     * @param null|string $inputBitRate
     * @return Ffmpeg
     */
    public function setInputBitRate($inputBitRate = NULL){
        if ($inputBitRate != NULL && (is_string($inputBitRate) || is_int($inputBitRate))) {
            $this->_inputBitRate = $inputBitRate;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputBitRate(){
        return $this->_inputBitRate;
    }

    /**
     * @param null|string $inputBitRateStreamSpecifier
     * @return Ffmpeg
     */
    public function setInputBitRateStreamSpecifier($inputBitRateStreamSpecifier = NULL){
        if ($inputBitRateStreamSpecifier != NULL && is_string($inputBitRateStreamSpecifier)) {
            $this->_inputBitRateStreamSpecifier = $inputBitRateStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getInputBitRateStreamSpecifier(){
        return $this->_inputBitRateStreamSpecifier;
    }

    /**
     * @param null|string $outputBitRate
     * @return Ffmpeg
     */
    public function setOutputBitRate($outputBitRate = NULL){
        if ($outputBitRate != NULL && (is_string($outputBitRate) || is_int($outputBitRate))) {
            $this->_outputBitRate = $outputBitRate;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputBitRate(){
        return $this->_outputBitRate;
    }

    /**
     * @param null|string $outputBitRateStreamSpecifier
     * @return Ffmpeg
     */
    public function setOutputBitRateStreamSpecifier($outputBitRateStreamSpecifier = NULL){
        if ($outputBitRateStreamSpecifier != NULL && is_string($outputBitRateStreamSpecifier)) {
            $this->_outputBitRateStreamSpecifier = $outputBitRateStreamSpecifier;
        }
        return $this;
    }

    /**
     * @return null|string
     */
    public function getOutputBitRateStreamSpecifier(){
        return $this->_outputBitRateStreamSpecifier;
    }

    /**
     * @param array $availableAr
     * @return Ffmpeg
     */
    public function setAvailableFlvAr($availableAr = NULL){
        if ($availableAr != NULL && is_array($availableAr)) {
            $this->_availableFlvAr = $availableAr;
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getAvailableFlvAr(){
        return $this->_availableFlvAr;
    }

    /**
     * @param int|null|string $timelimit
     * @return Ffmpeg
     */
    public function setTimelimit($timelimit = NULL){
        if ($timelimit != NULL && (is_string($timelimit) || is_int($timelimit))) {
            $this->_timelimit = $timelimit;
        }
        return $this;
    }

    /**
     * @return int|null|string
     */
    public function getTimelimit(){
        return $this->_timelimit;
    }

    /**
     * @return bool|string
     */
    public function getCommand(){
        $command = $this->_createCommand();
        return $command;
    }


    /**
     * @param null $command
     * @param bool $return
     * @return array|bool
     */
    public function setFfmpegCommand($command = NULL, $return = false){
        return $this->_setFfmpegCommand($command, $return);
    }





    //==================================================

    // Документация

    //==================================================

    /* Параметры Ffmpeg:

    -i {file_name} (input)

        Имя input(входного) файла


    -b

        Задаёт битрейт (В документации про эту опцию(одну из самых важных) нихуя не написано)


    -f {file_format} (input/output)

        Принудительно задаёт формат входного или выходного файла.
        По-дефолту, формат для входных файлов определяется автоматически, для выходных файлов по расширению файла,
        поэтому, в большинстве случаев, эта опция не требуется.


    -y

        Принудительно, без предупреждения, переписать выходной файл если файл с таким именем существует.


    -n

        Не перезаписывать выходные файлы, Выйти из программы, если указанный выходной файл уже существует.


    -c[:stream_specifier] {codec_name} (input/output,per-stream)
    -codec[:stream_specifier] {codec_name} (input/output,per-stream)

        Выбор кодера (при использовании перед выходным файлом)
        или декодера (при использовании перед входным файлом) для одного или нескольких потоков.
        {codec_name} -  название декодера/кодера
        или специальное значение - copy (только для выходного файла),
        чтобы указать, что поток не должен быть перекодированы.
        Формат {codec_name}: -codec[:stream_specifier] codec (input/output,per-stream)
        Пример: "ffmpeg -i INPUT -map 0 -c copy -c:v:1 libx264 -c:a:137 libvorbis OUTPUT".
        Подробнее в документации http://www.ffmpeg.org/ffmpeg.html#Main-options


    -t  {duration} (output)

        Останавливает запись вывода если его продолжительность превышает {duration}.
        {duration} может быть указана в секундах или в формате hh:mm:ss[.xxx].
        -to и -t являются взаимоисключающими и -t имеет приоритет.


    -to {position} (output)

        Останавливает запись вывода в {position}.
        {position} может быть указана в секундах или в формате hh:mm:ss[.xxx].
        -to и -t являются взаимоисключающими и -t имеет приоритет.


    -fs {limit_size} (output)

        Устанавливает ограничение на размер файла, в байтах.


    -ss {position} (input/output)

        При использовании в качестве опции ввода (перед -i), стремится найти {position} во входном файле.
        Примечание: в большинстве форматов, невозможно точно определить {position} и FFmpeg будет стремиться определить ближайшую точку до {position}.
        Если транскодирование и "-accurate_seek" включены (по умолчанию), то дополнительный сегмент между искомой точкой и {position} будет расшифрован и отброшен.
        При копировании потока или при использовании "-noaccurate_seek", копия будет сохранена.
        При использовании в качестве опции вывода (до выходного файла), декодирует но отбрасывает ввод, пока метка не достигнете {position}.
        {position} может быть указана в секундах или в формате hh:mm:ss[.xxx].


    -itsoffset {offset} (input)

        Устанавливает входное смещение времени.
        {offset} должно быть в формате соответствующем спецификации, см. (FFmpeg-утилиты - http://ffmpeg.org/ffmpeg-utils.html#time-duration-syntax) - синтаксис времени.
        {offset} добавляется к временными метками входных файлов. Указание положительного {offset} означает, что соответствующие потоки отображаются с задержкой, указанной в {offset}.

    -timestamp {date} (output)

        Установка даты/времени контейнера.
        {date} должна быть в формате соответствующем спецификации, см. (FFmpeg-утилиты - http://ffmpeg.org/ffmpeg-utils.html#time-duration-syntax) - синтаксис времени.


    -metadata[:metadata_specifier] {key=value} (output,per-metadata)

        Устанавливает пару {key=value} метаданных.
        Дополнительный metadata_specifier может быть установлен на поток или главу. Подробности в -map_metadata документации.
        Пример: "ffmpeg -i in.avi -metadata title="my title" out.flv" - задаёт title выходному файлу.
        Пример: "ffmpeg -i (input) -metadata:s:a:1 language=eng (output)" - устанавливает язык первому аудио-потоку


    -target {type} (output)

        Устанавливает целевой тип файла (VCD, SVCD, DVD, DV, DV50).
        {type} может быть с префиксом pal-, ntsc- or film- для использования соответствующего стандарта.
        Все параметры формата (битрейт, кодеки, размеры буферов) установятся автоматически.
        Вы можете просто задать:
        "ffmpeg -i myfile.avi -target vcd /tmp/vcd.mpg".
        Также можно задать дополнительные параметры, если они не противоречат стандарту:
        "ffmpeg -i myfile.avi -target vcd -bf 2 /tmp/vcd.mpg"


    -dframes {number} (output)

        Устанавливает количество кадров для записи. Это псевдоним для -frames:d.


    -frames[:stream_specifier] {framecount} (output,per-stream)

        Перестаёт записывать в поток после {framecount} кадров.


    -q[:stream_specifier] {q} (output,per-stream)
    -qscale[:stream_specifier] {q} (output,per-stream)

        Задаёт фиксированное качество (VBR). Значение -q/qscale кодек-зависимое.
        Если qscale используется без stream_specifier то оно применяется только к видеопотоку.


    -filter[:stream_specifier] {filtergraph} (output,per-stream)

        Задаёт filtergraph указанный в {filtergraph} и использует его для фильтрации потока.
        {filtergraph} это описание filtergraph для применения в потоке, он должен иметь один вход и один выход с одинаковым типом потока.
        В filtergraph, вход связан с этикеткой in, а выход с этикеткой out.
        См. руководство FFmpeg-filters для получения дополнительной информации о синтаксисе filtergraph.


    -filter_script[:stream_specifier] {filename} (output,per-stream)

        Эта опция похожа на '-filter ", с той лишь разницей, что ее аргумент является именем файла, из которого берётся описание filtergraph.


    -pre[:stream_specifier] {preset_name} (output,per-stream)

        Устанавливает пресет, для соответствующих потоков.


    -stats

        Отображает статистику кодирования. Включено по умолчанию, явно отключить можно, указав -nostats.


    -nostats

        Отключает отображение статистики кодирования.


    -progress {url}

        Отправить program-friendly информацию о прогрессе на указанный {url}.
        Информация о прогрессе записывается примерно каждую секунду, и в конце процесса кодирования.
        Состоит из пар "ключ = значение". Ключ состоит только из алфавитно-цифровых символов.
        Последний ключ из последовательности всегда "progress".


    -stdin

        Обеспечивает взаимодействие со стандартным вводом.
        Установлено по умолчанию, если стандартный ввод не используется в качестве входных данных.
        Чтобы явно отключить взаимодействие необходимо указать -nostdin.
        Отключение взаимодействие со стандартным вводом полезно, например,
        если FFmpeg находится в группе фоновых процессов. Примерно такой же результат может быть достигнут с FFmpeg ... </ Dev / null, но это требует оболочку.


    -debug_ts

        Отображение timestamp информации. По умолчанию отключено.
        Эта опция в основном полезна для тестирования и отладки,
        и выходной формат может изменяться от одной версии к другой,
        поэтому она не должна быть использована для портативных сценариев.
        См. также опциЮ -fdebug ts.


    -attach {filename} (output)

        Добавление вложения в выходной файл.
        Эта опция поддерживается несколькими форматами, такими как Matroska для, например, шрифтов, используемые в субтитрах.
        Вложения реализованы в виде определенного типа потока, так что эта опция будет добавлять новый поток в файл.
        В этом случае можно использовать per-stream варианты этого потока в обычном порядке.
        Потоки, созданные с помощью этой опции будут созданы после того как все другие потоки (то есть те, которые созданы с помощью -map или автоматического маппинга).
        Заметим, что для Matroska вы также должны установить тег MimeType метаданных.
        Пример: ffmpeg -i INPUT -attach DejaVuSans.ttf -metadata:s:2 mimetype=application/x-truetype-font out.mkv (при условии, что вложенный поток будет третим в выходном файле).


    -dump_attachment[:stream_specifier] {filename} (input,per-stream)

        Извлекает вложенный поток в файл с именем {filename}.
        Если {filename} пусто, то будет использоваться значение тега filename metadata.
        Пример: Извлечь первое вложение в файл с именем 'out.ttf':
            ffmpeg -dump_attachment:t:0 out.ttf -i INPUT
        Пример: Извлечь все вложения в файлы, определенные имен тегом filename:
            ffmpeg -dump_attachment:t "" -i INPUT
        Техническое примечание:
            Вложения реализованы как кодек еxtradata,
            поэтому эта опция может быть использован для извлечения extradata из любого потока, а не только извложения.


    -vframes {number} (output)

        Устанавливает количество видеокадров для записи. Это псевдоним для -frames:v


    -r[:stream_specifier] {fps} (input/output,per-stream)

        Устанавливает частоту кадров (Гц значение, дробное или аббревиатура).
        В качестве опции ввода, игнорирует любые временные метки, хранящиеся в файле, а вместо этого генерирует временные метки при постоянном уровне кадров в секунду {fps}.
        В качестве опции вывода, дублирует или удаляет входные кадры для достижения постоянного количества кадров в секунду {fps}.


    -s[:stream_specifier] {size} (input/output,per-stream)

        Устанавливает размер фрейма.
        В качестве опции ввода, это ярлык для приватной опции "video_size", поддерживаемой некоторыми демультиплексорами,
        для которых размер кадра либо не хранится в файле либо настраивается - например сырое видео или видеограббер.
        В качестве опции вывода, вставляет видео фильтр к концу соответствующего filtergraph.
        Пожалуйста, используйте шкалу фильтр, чтобы вставить {size} в начале или в каком-то другом месте.(Please use the scale filter directly to insert it at the beginning or some other place.)
        Формат 'wxh' (по умолчанию - такой же, как источника).


    -aspect[:stream_specifier] {aspect} (output,per-stream)

        Устанавливает соотношение сторон отображения видео, указанное в {aspect}.
        {aspect} может быть числом с плавающей точкой (float), или строка вида "num:den" , где num и den являются числителем и знаменателем соотношения сторон.
        Например, "4:3", "16:9", "1.3333" и "1,7777" являются допустимыми значениями аргументов.


    -vn (output)

        Отключить запись видео.


    -vcodec {codec} (output)

        Устанавливает видеокодек {codec}. Это псевдоним для -codec:v


    -pass[:stream_specifier] {n} (output,per-stream)

        Выберите pass номер (1 или 2). Он используется, чтобы сделать два прохода кодирования видео.
        При первом проходе статистика на видео записываются  в лог-файл (см. также опцию -passlogfile),
        При втором проходе, этот файл используется для генерации видео с точным запрашиваемой битрейтом.
        При первом проходе, вы можете просто отключить звук и установить выход на нулевой, примеры для ОС Windows и Unix:
            ffmpeg -i foo.mov -c:v libxvid -pass 1 -an -f rawvideo -y NUL - Windows
            ffmpeg -i foo.mov -c:v libxvid -pass 1 -an -f rawvideo -y /dev/null - Unix


    -passlogfile[:stream_specifier] {prefix} (output,per-stream)

        Устанавливает префикс {prefix} имени файла журнала логов второго прохода,
        {prefix} имени файла журнала логов по умолчанию является "ffmpeg2pass".
        Полное имя файла будет "PREFIX-N.log ', где N is a number specific to the output stream.


    -vf {filtergraph} (output)

        Создаёт filtergraph указанный в {filtergraph} и использует его для фильтрации потока.
        Это псевдоним для -filter:v, см. -filter опции.


    -pix_fmt[:stream_specifier] {format} (input/output,per-stream)

        Устанавливает формат пикселей.
        Используйте -pix_fmts, чтобы показать все поддерживаемые форматы пикселов.
        Если выбранный формат пикселей не поддерживается, FFmpeg будет выдавать предупреждение и выбрать лучший подходящий поддерживаемый формат пикселей.
        Если pix_fmt предваряется знаком +, FFmpeg будет завершаться с ошибкой, если требуемый формат пикселей не может быть выбран,
        и автоматическое преобразование внутри filtergraphs отключено.
        Если pix_fmt устанавливается просто в +, FFmpeg выбирает такой же формат пикселей в качестве входных данных (или выход графа) и отключает автоматическое преобразование.


    -sws_flags {flags} (input/output)

        Устанавливает SwScaler флаги (х.з. чо эт такое)


    -vdt {n}

        Discard threshold. (Отменяет порог?!Оо. Блядь, руки бы поотрывать, тому, кто писал документацию).


    -rc_override[:stream_specifier] {override} (output,per-stream)

        Управление скоростью коррекции для конкретных интервалов, в формате  "int,int,int" ​​список разделенный слэшами. Два первых значения - номера кадров начала и окончания,
        last one is quantizer to use if positive, or quality factor if negative.


    -ilme (ещё одна непонятная опция)

        interlacing - чересстрочная развёртка.
        Форсированно устанавливает поддержку interlacing в кодере (только MPEG-2 и MPEG-4).
        Используйте эту опцию, если ваш входной файл с interlacing и вы хотите сохранить interlacing формат с минимальными потерями.
        В качестве альтернативы можно deinterlace входной поток с помощью "-deinterlace", но это приведёт к потерям.


    -psnr

        Подсчитать PSNR сжатых кадров.


    -vstats

        Дамп статистики кодирования в "vstats_HHMMSS.log"


    -vstats_file {file}

        Дамп статистики кодирования в {file}


    -top[:stream_specifier] {n} (output,per-stream)

        top=1/bottom=0/auto=-1 field first (что за нах?)


    -dc {precision}

        Intra_dc_precision. (Ну тут всё ясно, без лишних слов.)


    -vtag {fourcc/tag} (output)

        Устанавливает видео tag/fourcc. Псевдоним для -tag:v.


    -qphist

        Показывает QP гистограмму


    -force_key_frames[:stream_specifier] {time[,time...]} (output,per-stream)
    -force_key_frames[:stream_specifier] {expr:expr} (output,per-stream)

        Принудительно устанавливает ключевые кадры в указанных временных метках, точнее на первых кадрах после каждого указанной метки.
        Подробнее в документации http://ffmpeg.org/ffmpeg.html#Advanced-Video-Options


    -copyinkf[:stream_specifier] (output,per-stream)

        При копировании потока, также скопирует неключевые кадры найденные в начале.


    -hwaccel[:stream_specifier] {hwaccel} (input,per-stream)

        Использует аппаратное ускорение для декодирования соответствующий потока(ов). Допустимые значения {hwaccel}:
            - "none" - Не использовать аапаратное ускорение (установлено по умолчанию);
            - "auto" - Автоматически выбрать метод аапаратного ускорения;
            - "vdpau" - Использовать VDPAU (декодирования видео и презентации API для Unix) аппаратное ускорение.
        Эта опция не имеет никакого эффекта, если выбранный {hwaccel} не доступен или не поддерживается на выбранном декодере.
        Обратите внимание, что большинство методов ускорения предназначены для воспроизведения,
        и это не будет быстрее, чем программное обеспечение для декодирования на современных процессорах.
        Кроме того, FFmpeg, как правило, нужно скопировать декодированные кадры из памяти GPU в системную память,
        что приводит к дальнейшей потере производительности. Эта опция таким образом, в основном, полезена для тестов.


    -hwaccel_device[:stream_specifier] {hwaccel_device} (input,per-stream)

        Задаёт устройство для использования аппаратного ускорения.
        Эта опция имеет смысл только когда включена опция "-hwaccel".
        Её точное значение зависит от выбранного метода аппаратного ускорения.
        "vdpau" - Для VDPAU, эта опция указывает X11 display/screen для использования.
        Если эта опция не задана, то используется значение переменной среды DISPLAY.


    -aframes {number} (output)

        Устанавливает количество кадров аудио. Псевдоним для -frames:a.


    -ar[:stream_specifier] {freq} (input/output,per-stream)

        Устанавливает частоту дискретизации аудиосигнала.
        Для выходных потоков он установлен по умолчанию к частоте соответствующего входного потока.
        Для входных потоков эта опция имеет смысл только для аудио захвата устройств демультиплексорами и сопоставляется с соответствующими опциями Demuxer.


    -aq {q} (output)

        Устанавливает качество звука (codec-specific, VBR). Псевдоним для -q:a.


    -ac[:stream_specifier] {channels} (input/output,per-stream)

        Устанавливает количество аудиоканалов.
        Для выходных потоков оно установлено по умолчанию как количество входных аудиоканалов.
        Для входных потоков эта опция имеет смысл только для захвата устройств демультиплексорами и сопоставляется с соответствующими опциями Demuxer.


    -an (output)

        Отключает запись аудио


    -acodec {codec} (input/output)

        Устанавливает аудиокодек. Псевдоним для -codec:a.


    -sample_fmt[:stream_specifier] {sample_fmt} (output,per-stream)

        Устанавливает формат аудио. Используйте -sample_fmts чтобы узнать доступные форматы.


    -af {filtergraph} (output)

        Создаёт filtergraph указанный в {filtergraph} и использует его для фильтрации потока.
        Псевдоним для -filter:a, см. опции -filter.

    -atag {fourcc/tag} (output)

        Форсированно устанавливает tag/fourcc. Псевдоним для -tag:a.


    -guess_layout_max {channels} (input,per-stream)

        Если макет входного канала не известен, попробует угадать, если он соответствует количеству не более указанного количества каналов.
        Например, 2 указывает Ffmpeg признать 1 канал как моно и 2 канала, как стерео, но не 6 каналов как 5,1.
        По умолчанию всегда пытается угадать. Используйте 0, чтобы отключить все догадки.

    -scodec {codec} (input/output)

        Устанавливает subtitle кодек. Псевдоним для -codec:s


    -sn (output)

        Отключает запись subtitle


    -fix_sub_duration

        Fix subtitles durations. For each subtitle, wait for the next packet in the same stream and adjust the duration of the first to avoid overlap.
        This is necessary with some subtitles codecs, especially DVB subtitles, because the duration in the original packet is only a rough estimate and the end is actually marked by an empty subtitle frame.
        Failing to use this option when necessary can result in exaggerated durations or muxing failures due to non-monotonic timestamps.
        Note that this option will delay the output of all data until the next subtitle packet is decoded: it may increase memory consumption and latency a lot.


    -canvas_size {size}

        Установливает размер канвы, используемой для визуализации субтитров.

    -timelimit {duration}

        Выйти из программы если Ffmpeg запущен более чем {duration} секунд назад


*/

    /**
     * @return string|bool
     */
    private function _createCommand(){

        if(self::$_pathToFfmpeg != NULL){
            $command = self::$_pathToFfmpeg;
            if($this->_isVersion){
                $command.= ' -version';
            }
            if($this->_input != NULL){
                if($this->_progress != NULL){
                    $command.=' -progress \''.$this->_progress.'\'';
                }
                if($this->_isStats){
                    $command.=' -stats';
                }
                if($this->_isDebugTs){
                    $command.=' -debug_ts';
                }
                if($this->_isStdin){
                    $command.=' -stdin';
                }
                if($this->_isNoStats){
                    $command.=' -nostats';
                }
                if($this->_isOverWrite){
                    $command.=' -y';
                }
                if($this->_isNotOverWrite){
                    $command.=' -n';
                }
                if($this->_isIlme){
                    $command.=' -ilme';
                }
                if($this->_isPsnr){
                    $command.=' -psnr';
                }
                if($this->_isVstats){
                    $command.=' -vstats';
                }
                if($this->_isQPhist){
                    $command.=' -qphist';
                }
                if($this->_isFixSubDuration){
                    $command.=' -fix_sub_duration';
                }
                if($this->_canvasSize != NULL){
                    $command.=' -canvas_size '.$this->_canvasSize;
                }
                if($this->_vstatsFile != NULL){
                    $command.=' -vstats_file '.$this->_vstatsFile;
                }
                if($this->_inputSeekPosition != NULL){
                    $command.=' -ss '.$this->_inputSeekPosition;
                }
                if($this->_vdt != NULL){
                    $command.=' -vdt '.$this->_vdt;
                }
                if($this->_itsoffset != NULL){
                    $command.=' -itsoffset '.$this->_itsoffset;
                }
                if($this->_timelimit != NULL){
                    $command.=' -timelimit '.$this->_timelimit;
                }
                if($this->_dumpAttachment != NULL){
                    $command.=' -dump_attachment';
                    if($this->_dumpAttachmentStreamSpecifier != NULL){
                        $command.=$this->_dumpAttachmentStreamSpecifier;
                    }
                    $command.=' '.$this->_dumpAttachment;
                }
                if($this->_inputFrameRate != NULL){
                    $command.=' -r';
                    if($this->_inputFrameRateStreamSpecifier != NULL){
                        $command.=$this->_inputFrameRateStreamSpecifier;
                    }
                    $command.=' '.$this->_inputFrameRate;
                }
                if($this->_inputSize != NULL){
                    $command.=' -s';
                    if($this->_inputSizeStreamSpecifier != NULL){
                        $command.=$this->_inputSizeStreamSpecifier;
                    }
                    $command.=' '.$this->_inputSize;
                }
                if($this->_inputFileFormat != NULL){
                    $command.=' -f '.$this->_inputFileFormat;
                }
                if($this->_inputCodec != NULL){
                    $command.=' -c';
                    if($this->_inputCodecStreamSpecifier != NULL){
                        $command.=$this->_inputCodecStreamSpecifier;
                    }
                    $command.=' '.$this->_inputCodec;
                }
                if($this->_inputPixelFormat != NULL){
                    $command.=' -pix_fmt';
                    if($this->_inputPixelFormatStreamSpecifier != NULL){
                        $command.=$this->_inputPixelFormatStreamSpecifier;
                    }
                    $command.=' '.$this->_inputPixelFormat;
                }
                if($this->_inputSwsFlags != NULL){
                    $command.=' -sws_flags '.$this->_inputSwsFlags;
                }
                if($this->_intraDcPrecision != NULL){
                    $command.=' -dc '.$this->_intraDcPrecision;
                }
                if($this->_hwaccel != NULL){
                    $command.=' -hwaccel';
                    if($this->_hwaccelStreamSpecifier != NULL){
                        $command.=$this->_hwaccelStreamSpecifier;
                    }
                    $command.=' '.$this->_hwaccel;
                }
                if($this->_hwaccelDevice != NULL){
                    $command.=' -hwaccel_device';
                    if($this->_hwaccelDeviceStreamSpecifier != NULL){
                        $command.=$this->_hwaccelDeviceStreamSpecifier;
                    }
                    $command.=' '.$this->_hwaccelDevice;
                }
                if($this->_inputAr != NULL){
                    $command.=' -ar';
                    if($this->_inputArStreamSpecifier != NULL){
                        $command.=$this->_inputArStreamSpecifier;
                    }
                    $command.=' '.$this->_inputAr;
                }
                if($this->_inputAudioChannels != NULL){
                    $command.=' -ac';
                    if($this->_inputAudioChannelsStreamSpecifier != NULL){
                        $command.=$this->_inputAudioChannelsStreamSpecifier;
                    }
                    $command.=' '.$this->_inputAudioChannels;
                }
                if($this->_inputAudioCodec != NULL){
                    $command.=' -acodec '.$this->_inputAudioCodec;
                }
                if($this->_guessLayoutMax != NULL){
                    $command.=' -guess_layout_max '.$this->_guessLayoutMax;
                }
                if($this->_inputSubtitleCodec != NULL){
                    $command.=' -scodec '.$this->_inputSubtitleCodec;
                }
                if($this->_inputBitRate != NULL){
                    $command.=' -b';
                    if($this->_inputBitRateStreamSpecifier != NULL){
                        $command.=$this->_inputBitRateStreamSpecifier;
                    }
                    $command.=' '.$this->_inputBitRate;
                }

                //добавляем инпут
                $command.=' -i \''.$this->_input.'\'';
                
            }

            if($this->_output != NULL){
                if($this->_pre != NULL){
                    $command.=' -pre';
                    if($this->_preStreamSpecifier != NULL){
                        $command.=$this->_preStreamSpecifier;
                    }
                    $command.=' '.$this->_pre;
                }
                if($this->_filter != NULL){
                    $command.=' -filter';
                    if($this->_filterStreamSpecifier != NULL){
                        $command.=$this->_filterStreamSpecifier;
                    }
                    $command.=' '.$this->_filter;
                }
                if($this->_filterScript != NULL){
                    $command.=' -filter_script';
                    if($this->_filterScriptStreamSpecifier != NULL){
                        $command.=$this->_filterScriptStreamSpecifier;
                    }
                    $command.=' '.$this->_filterScript;
                }
                if($this->_dframes != NULL){
                    $command.=' -dframes '.$this->_dframes;
                }
                if($this->_attach != NULL){
                    $command.=' -attach '.$this->_attach;
                }
                if($this->_frames != NULL){
                    $command.=' -frames';
                    if($this->_framesStreamSpecifier != NULL){
                        $command.=$this->_framesStreamSpecifier;
                    }
                    $command.=' '.$this->_frames;
                }
                if($this->_outputFrameRate != NULL){
                    $command.=' -r';
                    if($this->_outputFrameRateStreamSpecifier != NULL){
                        $command.=$this->_outputFrameRateStreamSpecifier;
                    }
                    $command.=' '.$this->_outputFrameRate;
                }
                if($this->_vframes != NULL){
                    $command.=' -vframes '.$this->_vframes;
                }
                if($this->_target != NULL){
                    $command.=' -target '.$this->_target;
                }
                if($this->_metadata != NULL){
                    $command.=' -metadata';
                    if($this->_metadataSpecifier != NULL){
                        $command.=$this->_metadataSpecifier;
                    }
                    $command.=' '.$this->_metadata;
                }
                if($this->_qscale != NULL){
                    $command.=' -q';
                    if($this->_qscaleStreamSpecifier != NULL){
                        $command.=$this->_qscaleStreamSpecifier;
                    }
                    $command.=' '.$this->_qscale;
                }
                if($this->_timestamp != NULL){
                    $command.=' -timestamp '.$this->_timestamp;
                }
                if($this->_outputFileSizeLimit != NULL){
                    $command.=' -fs '.$this->_outputFileSizeLimit;
                }
                if($this->_stopOutputDuration != NULL){
                    $command.=' -t '.$this->_stopOutputDuration;
                }
                if($this->_stopOutputPosition != NULL){
                    $command.=' -to '.$this->_stopOutputPosition;
                }
                if($this->_outputFileFormat != NULL){
                    $command.=' -f '.$this->_outputFileFormat;
                }
                if($this->_outputCodec != NULL){
                    $command.=' -c';
                    if($this->_outputCodecStreamSpecifier != NULL){
                        $command.=$this->_outputCodecStreamSpecifier;
                    }
                    $command.=' '.$this->_outputCodec;
                }
                if($this->_outputSeekPosition != NULL){
                    $command.=' -ss '.$this->_outputSeekPosition;
                }
                if($this->_outputSize != NULL){
                    $command.=' -s';
                    if($this->_outputSizeStreamSpecifier != NULL){
                        $command.=$this->_outputSizeStreamSpecifier;
                    }
                    $command.=' '.$this->_outputSize;
                }
                if($this->_aspect != NULL){
                    $command.=' -aspect';
                    if($this->_aspectStreamSpecifier != NULL){
                        $command.=$this->_aspectStreamSpecifier;
                    }
                    $command.=' '.$this->_aspect;
                }
                if($this->_isDisableRecording){
                    $command.=' -vn';
                }
                if($this->_videoCodec != NULL){
                    $command.=' -vcodec '.$this->_videoCodec;
                }
                if($this->_pass != NULL){
                    $command.=' -pass';
                    if($this->_passStreamSpecifier != NULL){
                        $command.=$this->_passStreamSpecifier;
                    }
                    $command.=' '.$this->_pass;
                }
                if($this->_passLogFile != NULL){
                    $command.=' -passlogfile';
                    if($this->_passLogFileStreamSpecifier != NULL){
                        $command.=$this->_passLogFileStreamSpecifier;
                    }
                    $command.=' '.$this->_passLogFile;
                }
                if($this->_filterGraph != NULL){
                    $command.=' -vf '.$this->_filterGraph;
                }
                if($this->_outputPixelFormat != NULL){
                    $command.=' -pix_fmt';
                    if($this->_outputPixelFormatStreamSpecifier != NULL){
                        $command.=$this->_outputPixelFormatStreamSpecifier;
                    }
                    $command.=' '.$this->_outputPixelFormat;
                }
                if($this->_outputSwsFlags != NULL){
                    $command.=' -sws_flags '.$this->_outputSwsFlags;
                }
                if($this->_rcOverride != NULL){
                    $command.=' -rc_override';
                    if($this->_rcOverrideStreamSpecifier != NULL){
                        $command.=$this->_rcOverrideStreamSpecifier;
                    }
                    $command.=' '.$this->_rcOverride;
                }
                if($this->_top != NULL){
                    $command.=' -top';
                    if($this->_topStreamSpecifier != NULL){
                        $command.=$this->_topStreamSpecifier;
                    }
                    $command.=' '.$this->_top;
                }
                if($this->_vtag != NULL){
                    $command.=' -vtag '.$this->_vtag;
                }
                if($this->_forceKeyFrames != NULL){
                    $command.=' -force_key_frames';
                    if($this->_forceKeyFramesStreamSpecifier != NULL){
                        $command.=$this->_forceKeyFramesStreamSpecifier;
                    }
                    $command.=' '.$this->_forceKeyFrames;
                }
                if($this->_copyinkf != NULL){
                    $command.=' -copyinkf';
                    if($this->_copyinkfStreamSpecifier != NULL){
                        $command.=$this->_copyinkfStreamSpecifier;
                    }
                    $command.=' '.$this->_copyinkf;
                }
                if($this->_aframes != NULL){
                    $command.=' -aframes '.$this->_aframes;
                }
                if($this->_outputAr != NULL){
                    $command.=' -ar';
                    if($this->_outputArStreamSpecifier != NULL){
                        $command.=$this->_outputArStreamSpecifier;
                    }
                    $command.=' '.$this->_outputAr;
                }
                if($this->_audioQuality != NULL){
                    $command.=' -aq '.$this->_audioQuality;
                }
                if($this->_outputAudioChannels != NULL){
                    $command.=' -ac';
                    if($this->_outputAudioChannelsStreamSpecifier != NULL){
                        $command.=$this->_outputAudioChannelsStreamSpecifier;
                    }
                    $command.=' '.$this->_outputAudioChannels;
                }
                if($this->_isDisabledAudioRecord){
                    $command.=' -an';
                }
                if($this->_outputAudioCodec != NULL){
                    $command.=' -acodec '.$this->_outputAudioCodec;
                }
                if($this->_sampleFormat != NULL){
                    $command.=' -sample_fmt';
                    if($this->_sampleFormatStreamSpecifier != NULL){
                        $command.=$this->_sampleFormatStreamSpecifier;
                    }
                    $command.=' '.$this->_sampleFormat;
                }
                if($this->_audioFiltergraph != NULL){
                    $command.=' -af '.$this->_audioFiltergraph;
                }
                if($this->_audioTag != NULL){
                    $command.=' -atag '.$this->_audioTag;
                }
                if($this->_outputSubtitleCodec != NULL){
                    $command.=' -scodec '.$this->_outputSubtitleCodec;
                }
                if($this->_isDisableSubtitleRecording){
                    $command.=' -sn';
                }
                if($this->_outputBitRate != NULL){
                    $command.=' -b';
                    if($this->_outputBitRateStreamSpecifier != NULL){
                        $command.=$this->_outputBitRateStreamSpecifier;
                    }
                    $command.=' '.$this->_outputBitRate;
                }


                // добавляем output
                $command.=' -vsync vfr \''.$this->_output.'\' > /dev/null &';
            }

        }
        else{
            $command = '';
        }
        $logCategory = "system.ffmpeg.createCommand";
        Yii::log("Была создана команда - ".$command,"info", $logCategory);
        return $command;
    }


    /**
     * @param null $command
     * @param bool $return
     * @return array|bool
     * @throws CHttpException
     */
    private function _setFfmpegCommand($command = NULL, $return = false){

        if(self::$_pathToFfmpeg === NULL){
            throw new CHttpException(403,"Ffmpeg doesn't exist");
        }
        else{
            if($return){
                return $this->_setCommand($command,true);
            }
            else{
                $this->_setCommand($command);
            }
        }
    }


    /**
     * @param null $command
     * @param bool $return
     * @return array|bool
     */
    private function _setCommand($command = NULL, $return = false){
        if($command != NULL && is_string($command)){
            if($return){
                $cwd = $this->_cwd;
                $descriptorSpec = $this->_getDescriptorSpec();
                $pipes = array();
                $process = proc_open($command, $descriptorSpec, $pipes, $cwd);

                if (is_resource($process)) {
                    fclose($pipes[0]);

                    $output = stream_get_contents($pipes[1]);
                    fclose($pipes[1]);

                    $errors = stream_get_contents($pipes[2]);
                    fclose($pipes[2]);

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
                exec($command);
            }
        }
        else{
            return false;
        }
    }

    /**
     * @return array|bool
     * @throws CHttpException
     */
    private function _stopFfmpeg(){
        if(self::$_pathToFfmpeg === NULL){
            throw new CHttpException(403,"Ffmpeg doesn't exist");
        }
        else{
            $command = self::$_pathToFfmpeg.' -stop';
            return $this->_setCommand($command);
        }
    }

    /**
     * @return array
     */
    private function _getDescriptorSpec(){
        $descriptorsSpec = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w'),
        );
        return $descriptorsSpec;
    }

    /**
     * @return array|bool
     */
    public function getFfmpegVersion(){
        $this->setIsVersion();
        $command = $this->_createCommand();
        if($command){
            $result = $this->_setCommand($command);
        }
        return $result;
    }

    /**
     * @param null|string $path
     * @return bool
     */
    public static function checkFfmpegExist($path = NULL){
        if($path != NULL && is_string($path)){
            self::$_pathToFfmpeg = $path;
        }
        $command = self::$_pathToFfmpeg.' -version';
        ob_start();
        passthru($command,$status);
        $output = ob_get_contents();
        ob_end_clean();
        $commandResult = array(
            'output' => $output,
            'status' => $status,
        );
        if($commandResult['status'] == 0){
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * @param bool $return
     * @return array|bool
     */
    public function convertToFlv($return = false){
        $input = $this->_input;
        $output = $this->_output;
        $ar = $this->_outputAr;

        if($input === NULL){
            return array(
                'status' => 'error',
                'message' => 'Input file not set'
            );
        }
        if($output === NULL){
            return array(
                'status' => 'error',
                'message' => 'Output file not set'
            );
        }
        if($ar === NULL){
            return array(
                'status' => 'error',
                'message' => 'Audio sampling frequency not set'
            );
        }
        if(!in_array((int)$ar,$this->_availableFlvAr)){
            return array(
                'status' => 'error',
                'message' => 'FLV does not support audio sample rate '.$ar
            );
        }

        $command = $this->_createCommand();
        
        if($command){
            if($return){
                return $this->_setFfmpegCommand($command,true);
            }
            else{
                $this->_setFfmpegCommand($command);
            }
        }
    }

    /**
     * @param bool $return
     * @return array|bool
     */
    public function createVideoPreviews($return = false){
        $input = $this->_input;
        $output = $this->_output;
        if($input === NULL){
            return array(
                'status' => 'error',
                'message' => 'Input file not set'
            );
        }
        if($output === NULL){
            return array(
                'status' => 'error',
                'message' => 'Output file not set'
            );
        }

        $command = $this->_createCommand();

        if($command){
            if($return){
                return $this->_setFfmpegCommand($command,true);
            }
            else{
                $this->_setFfmpegCommand($command);
            }
        }
    }

    /**
     * @param $file
     * @param null $startProgressData
     * @return array
     */
    private function _checkProcess($file, $startProgressData = NULL){

        $endProgressData = file($file);
        $end = trim(array_pop($endProgressData));

        if($startProgressData == $endProgressData){
            if($end == 'progress=end'){
                unlink($file);
                return array(
                    'status' => 'success',
                    'message' => 'file converted successfully'
                );
            }
            elseif($end == 'progress=continue'){
                return array(
                    'status' => 'error',
                    'message' => 'file converted with errors'
                );
            }
            else{
                return array(
                    'status' => 'error',
                    'message' => 'file not converted'
                );
            }
        }
        else{
            sleep(10);
            return $this->_checkProcess($file, $endProgressData);
        }
    }



} 