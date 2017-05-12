'use strict';

/*
 * angular-google-plus-directive v0.0.2
 * ♡ CopyHeart 2013 by Jerad Bitner http://jeradbitner.com
 * Copying is an act of love. Please copy.
 * Modified by Boni Gopalan to include Google oAuth2 Login.
 * Modified by @barryrowe to provide flexibility in clientid, and rendering
 *  --loads auth2 and runs init() so clientid can still be defined as an attribute
 *  --attribute 'autorender' added. Defaults to true; if false gapi.signin2.render()
 *    won't be called on the element
 *  --attribute 'customtargetid' added. Allows any custom element id to be the target of
 *    attachClickHandler() if 'autorender' is set to false
 *  --if 'autorender' is false and no 'customtargetid' is set, a decently styled button is
 *    rendered into the directive root element (requires inclusion of supporting css)
 */

angular.module('directive.g+signin', [])