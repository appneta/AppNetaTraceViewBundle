<?php
/**
 * Oboe API for PHP
 *
 * This can be used for autocompletion in many major PHP editors
 * provides documentation for the code
 * and can be used on systems where the oboe extension is not loaded
 * to provide no-op versions of functionality
 */

if(!extension_loaded('oboe') && !function_exists('oboe_set_context')) {

    /**
     * Get string representation of current global context (X-trace) being used
     * if request is not tracing, will return false
     *
     * @return string|false
     */
    function oboe_get_context() {
        return false;
    }

    /**
     * Set a string value for the current global context (X-trace) being used
     * will not start a trace, but will set the context to use for tracing even
     * if not currently tracing
     *
     * @return bool true for valid set, false for invalid x-trace sent
     */
    function oboe_set_context($context) {
        return true;
    }

    /**
     * Attempts to start a new trace
     * Uses liboboe and feeds in optional incoming xtrace edge
     * xmeta header, and PHP set sample mode or sample rate if applicable
     *
     * If it returns false then tracing is not started
     *
     * if context is set before a trace is started the context provided will be used
     * otherwise a new random context is generated
     *
     * Will throw a PHP Notice if start trace has already been called or autotracing is on
     *
     * @param string layer name for custom tracing
     * @param string xtrace (optional) incoming xtrace edge (default = null)
     * @param string xmeta (optional) incoming xmeta value (default = null)
     * @param mixed info (optional) if arrayaccess (array or object with hashtable) is sent then the items in the key
     *              value pairs that aren't reserved are sent with the beginning trace
         * @param mixed backtrace (optional) if arrayaccess (array or object with hashtable) that is used as a backtrace
     *               if true is passed PHP generated backtrace is sent, if false
     *               is passed then no backtrace is sent
     *
     * @return array('sample_rate' => value
     *               'sample_source' => value) or false
     */
    function oboe_start_trace($layer, $xtrace = null, $xmeta = null, $info = null, $backtrace = true) {
        return false;
    }

    /**
     * Stops a trace
     *
     * If it returns false then tracing was never started or an error occurred
     *
     * @param mixed info (optional) if arrayaccess (array or object with hashtable) is sent then the items in the key
     *              value pairs that aren't reserved are sent with the beginning trace
         * @param mixed backtrace (optional) if arrayaccess (array or object with hashtable) that is used as a backtrace
     *               if true is passed PHP generated backtrace is sent, if false
     *               is passed then no backtrace is sent
     * @param mixed edge (optional) if arrayaccess (array or object with hashtable) is sent then the items are treated
     *              as additional edges to add, if it's a single string the string is added
     *
     * @return boolean (true on success, false on failure)
     */
    function oboe_end_trace($info = null, $backtrace = true, $edge = null) {
        return false;
    }

    /**
     * Is this request/script currently tracing
     *
     * @return boolean (true on success, false on failure)
     */
    function oboe_is_tracing() {
        return false;
    }

    /**
     * Has tracing been started? either by normal means (when use_custom_start_trace is off) or a call to oboe_start_trace
     *
     * @return boolean (true on success, false on failure)
     */
    function oboe_trace_started() {
        return false;
    }

    /**
     * Creates an event
     *
     * @param string layer (optional) layer name to use (may be null)
     * @param string label label name to trace (entry, exit, info, etc)
     * @param mixed info (optional) if arrayaccess (array or object with hashtable) is sent then the items in the key
     *              value pairs that aren't reserved are sent with the beginning trace
         * @param mixed backtrace (optional) if arrayaccess (array or object with hashtable) that is used as a backtrace
     *               if true is passed PHP generated backtrace is sent, if false
     *               is passed then no backtrace is sent
     * @param mixed edge (optional) if arrayaccess (array or object with hashtable) is sent then the items are treated
     *              as additional edges to add, if it's a single string the string is added
     * @return boolean (true on success, false on failure)
     */
    function oboe_log($layer, $label, $info = null, $backtrace = true, $edge = null) {
        return false;
    }

    /**
     * Creates a new entry event
     *
     * @param string layer layer name to use
     * @param mixed info (optional) if arrayaccess (array or object with hashtable) is sent then the items in the key
     *              value pairs that aren't reserved are sent with the beginning trace
     * @param mixed backtrace (optional) if arrayaccess (array or object with hashtable) that is used as a backtrace
     *               if true is passed PHP generated backtrace is sent, if false
     *               is passed then no backtrace is sent
     *
     * @return boolean (true on success, false on failure)
     */
    function oboe_log_entry($layer, $info = null, $backtrace = true) {
        return false;
    }

    /**
     * Creates a new exit event
     *
     * @param string layer layer name to use
     * @param mixed info (optional) if arrayaccess (array or object with hashtable) is sent then the items in the key
     *              value pairs that aren't reserved are sent with the beginning trace
     * @param mixed backtrace (optional) if arrayaccess (array or object with hashtable) that is used as a backtrace
     *               if true is passed PHP generated backtrace is sent, if false
     *               is passed then no backtrace is sent
     * @param mixed edge (optional) if arrayaccess (array or object with hashtable) is sent then the items are treated
     *              as additional edges to add, if it's a single string the string is added
     * @return boolean (true on success, false on failure)
     */
    function oboe_log_exit($layer, $info = null, $backtrace = true, $edge = null) {
        return false;
    }

    /**
     * Creates an error event
     *
     * @param string layer layer name to use
     * @param string message error message
     * @param int PHP error code
     * @param mixed info (optional) if arrayaccess (array or object with hashtable) is sent then the items in the key
     *              value pairs that aren't reserved are sent with the beginning trace
     * @param mixed backtrace (optional) if arrayaccess (array or object with hashtable) that is used as a backtrace
     *               if true is passed PHP generated backtrace is sent, if false
     *               is passed then no backtrace is sent
     * @return boolean (true on success, false on failure)
     */
    function oboe_log_error($layer, $message, $code, $info = true, $backtrace = true, $edge = null) {
        return false;
    }

    /**
     * Creates an event from a PHP exception
     *
     * @param string layer layer name to use
     * @param object instanceof Exception exception
     * @param mixed info (optional) if arrayaccess (array or object with hashtable) is sent then the items in the key
     *              value pairs that aren't reserved are sent with the beginning trace
     * @param mixed backtrace (optional) if arrayaccess (array or object with hashtable) that is used as a backtrace
     *               if true is passed PHP generated backtrace is sent, if false
     *               is passed then no backtrace is sent
     * @param mixed edge (optional) if arrayaccess (array or object with hashtable) is sent then the items are treated
     *              as additional edges to add, if it's a single string the string is added
     * @return boolean (true on success, false on failure)
     */
    function oboe_log_exception($layer, Exception $e, $info = null, $backtrace = true, $edge = null) {
        return false;
    }
}