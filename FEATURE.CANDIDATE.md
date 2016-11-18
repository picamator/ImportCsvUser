Feature Candidate
=================
Features that are nice to have. It's like a TODO for putting on the issues list.

Id  | Summary                                               | Description
--- |---                                                    | --- 
1   | Use value objects for `zipcode`, `gender`             | They are data structure not a simple `string`
2   | Use only needed Symfony components                    | Remove all unused dependencies 
3   | Keep broken rows in csv files                         | Create csv with skipped rows so user can correct it and re-import
4   | Split large CSV for parallel running                  | Use https://github.com/picamator/SplitCSV/
