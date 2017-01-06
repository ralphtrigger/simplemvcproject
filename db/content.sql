/* 
 * Copyright 2016 trigger.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
/**
 * Author:  trigger
 * Created: Dec 17, 2016
 */

-- Populate the data base
insert into article 
values (1, 'First article', 'Hi there! this is the first article');

insert into article 
values (2, 'Lorem Ipsum', 'Lorem ipsum dolor sit amet, consectetur adipisicing 
elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut 
aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in 
voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint 
occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit 
anim id est laborum.');

insert into article
values (3, 'Third article', 'Curabitur pretium tincidunt lacus. Nulla gravida 
orci a odio. Nullam varius, turpis et commodo pharetra, est eros bibendum elit, 
nec luctus magna felis sollicitudin mauris. Integer in mauris eu nibh euismod 
gravida. Duis ac tellus et risus vulputate vehicula. Donec lobortis risus a 
elit. Etiam tempor. Ut ullamcorper, ligula eu tempor congue, eros est euismod 
turpis, id tincidunt sapien risus a quam. Maecenas fermentum consequat mi. 
Donec fermentum. Pellentesque malesuada nulla a mi. Duis sapien sem, aliquet 
nec, commodo eget, consequat quis, neque. Aliquam faucibus, elit ut dictum 
aliquet, felis nisl adipiscing sapien, sed malesuada diam lacus eget erat. 
Cras mollis scelerisque nunc. Nullam arcu. Aliquam consequat. 
Curabitur augue lorem, dapibus quis, laoreet et, pretium ac, nisi. Aenean magna 
nisl, mollis quis, molestie eu, feugiat in, orci. In hac habitasse platea 
dictumst.');

/* raw password is 'john' */
insert into t_user values
(1, 'JohnDoe', '$2y$13$F9v8pl5u5WMrCorP9MLyJeyIsOLj.0/xqKd/hqa5440kyeB7FQ8te', 
'YcM=A$nsYzkyeDVjEUa7W9K', 'ROLE_USER');
/* raw password is 'jane' */
insert into t_user values
(2, 'JaneDoe', '$2y$13$qOvvtnceX.TjmiFn4c4vFe.hYlIVXHSPHfInEG21D99QZ6/LM70xa', 
'dhMTBkzwDKxnD;4KNs,4ENy', 'ROLE_USER');
/* raw password is '@dm1n' */
insert into t_user values
(3, 'admin', '$2y$13$A8MQM2ZNOi99EW.ML7srhOJsCaybSbexAj/0yXrJs4gQ/2BqMMW2K', 
'EDDsl&fBCJB|a5XUtAlnQN8', 'ROLE_ADMIN');

INSERT INTO comment
VALUES (1, 'Great! Keep up the good work.', 1, 1);

INSERT INTO comment
VALUES (2, "Thank you, I'll try my best.", 1, 2);
