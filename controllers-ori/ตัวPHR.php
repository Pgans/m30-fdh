<?php 
###### SERVER
POST 
https://phr1.moph.go.th/api/UpdatePHRv1

####### JSON #######################
{
        "managingOrganization": {
            "type": "Organization",
            "identifier": {
                "use": "official",
                "system": "https://bps.moph.go.th/hcode/5",
                "value": "10953"
            },
            "display": "โรงพยาบาลรพ.ม่วงสามสิบ"
        },
        "Patient": {
            "identifier": [
                {
                    "use": "official",
                    "system": "https://www.dopa.go.th",
                    "type": "CID",
                    "value": "3120101350060",
                    "period": {
                        "start": "1955"
                    }
                },
                {
                    "use": "official",
                    "system": "https://sil-th.org/hn",
                    "assigner": {
                        "use": "official",
                        "system": "https://bps.moph.go.th/hcode/5",
                        "value": "10953",
                        "display": "โรงพยาบาลรพ.ม่วงสามสิบ"
                    },
                    "type": "HN",
                    "value": "110135",
                    "period": {
                        "start": "2022"
                    }
                }
            ],
            "active": true,
            "name": [
                {
                    "use": "official",
                    "text": "นายสุชาติ พลอยประดับแสง",
                    "languageCode": "TH",
                    "family": "สุชาติ พลอยประดับแสง",
                    "given": [
                        "สุชาติ"
                    ],
                    "prefix": [
                        "นาย"
                    ],
                    "suffix": [
                        "พลอยประดับแสง"
                    ],
                    "period": {
                        "start": "2022-02-25T00:00:00.000Z"
                    }
                },
                {
                    "use": "official",
                    "text": "undefined.Suchart Ploypradubsang",
                    "languageCode": "EN",
                    "family": "Suchart Ploypradubsang",
                    "given": [
                        "Suchart"
                    ],
                    "prefix": [
                        "-"
                    ],
                    "suffix": [
                        "Ploypradubsang"
                    ],
                    "period": {
                        "start": "2022-02-25T00:00:00.000Z"
                    }
                }
            ],
            "telecom": [
                {
                    "system": "phone",
                    "value": "0981152102",
                    "use": "mobile",
                    "rank": "1",
                    "period": {
                        "start": "2022-02-25T00:00:00.000Z"
                    }
                }
            ],
            "gender": "male",
            "birthDate": "1955-03-20T00:00:00.000Z",
            "deceasedBoolean": false,
            "nationality": {
                "coding": [
                    {
                        "system": "http://www.thcc.or.th/download/nationalitycode.xls",
                        "code": "99",
                        "display": "ไทย"
                    }
                ],
                "text": "ไทย"
            },
            "address": [
                {
                    "use": "home",
                    "type": "both",
                    "text": "ที่อยู่",
                    "line": [
                        "166",
                        "ม่วงสามสิบ หมู่ 1"
                    ],
                    "city": "ม่วงสามสิบ",
                    "district": "ม่วงสามสิบ",
                    "state": "อุบลราชธานี",
                    "postalCode": "",
                    "country": "TH",
                    "period": {
                        "start": "2022-02-25T00:00:00.000Z"
                    },
                    "address_code": "341401"
                }
            ],
            "maritalStatus": {
                "coding": [
                    {
                        "system": "http://terminology.hl7.org/CodeSystem/v3-MaritalStatus",
                        "code": "W",
                        "display": "หม้าย"
                    }
                ],
                "text": "หม้าย"
            },
            "contact": [
                {
                    "relationship": [
                        {
                            "coding": [
                                {
                                    "system": "https://www.this.or.th",
                                    "code": "1",
                                    "display": "ญาติ"
                                }
                            ],
                            "text": "ญาติ"
                        }
                    ],
                    "name": [
                        {
                            "use": "official",
                            "text": "นางอมรรัตน์  จันทร์หอม                  ",
                            "family": "นางอมรรัตน์  จันทร์หอม                  ",
                            "languageCode": "TH",
                            "given": [
                                ""
                            ],
                            "prefix": [
                                ""
                            ],
                            "suffix": [],
                            "period": {
                                "start": "2022-02-25T00:00:00.000Z"
                            }
                        }
                    ],
                    "telecom": [
                        {
                            "system": "phone",
                            "value": "0859648771",
                            "use": "mobile",
                            "rank": "1",
                            "period": {
                                "start": "2022-02-25T00:00:00.000Z"
                            }
                        }
                    ],
                    "address": [
                        {
                            "use": "home",
                            "type": "both",
                            "text": "ที่อยู่",
                            "line": [
                                "1669/235   ซอยสรณคมน์ 25 บ้านม่วงสามสิบ หมู่ 1ตำบลม่วงสามสิบ อำเภอม่วงสามสิบ จังหวัดอุบลราชธานี"
                            ],
                            "city": "ม่วงสามสิบ",
                            "district": "ม่วงสามสิบ",
                            "state": "อุบลราชธานี",
                            "postalCode": "",
                            "country": "TH",
                            "period": {
                                "start": "2022-02-25T00:00:00.000Z"
                            },
                            "address_code": "341401"
                        }
                    ],
                    "gender": "male"
                }
            ]
        },
        "AllergyIntolerance": [],
        "Encounter": [
            {
                "managingOrganization": {
                    "type": "Organization",
                    "identifier": {
                        "use": "official",
                        "system": "https://bps.moph.go.th/hcode/5",
                        "value": "10953"
                    },
                    "display": "โรงพยาบาลรพ.ม่วงสามสิบ"
                },
                "identifier": [
                    {
                        "use": "official",
                        "system": "https://bps.moph.go.th/vn",
                        "value": "0002850604"
                    },
                    {
                        "use": "official",
                        "system": "https://sil-th.org/hn",
                        "value": "072746",
                        "period": {
                            "start": "2023"
                        }
                    }
                ],
                "status": "finished",
                "class": {
                    "system": "https://terminology.hl7.org/CodeSystem/v3-ActCode",
                    "code": "AMB",
                    "display": "ambulatory"
                },
                "subclass": {
                    "system": "https://bps.moph.go.th/subclass",
                    "code": "26",
                    "display": "แพทย์ทางเลือก"
                },
                "division": {
                    "system": "https://bps.moph.go.th/division",
                    "code": "26",
                    "display": "แพทย์ทางเลือก"
                },
                "type": {
                    "coding": [
                        {
                            "system": "https://spd.moph.go.th/new_bps/43file_version2.3",
                            "code": "1",
                            "display": "มารับบริการเอง"
                        }
                    ],
                    "text": "มารับบริการเอง"
                },
                "priority": {
                    "coding": [
                        {
                            "system": "http://terminology.hl7.org/CodeSystem/v3-ActPriority",
                            "code": "R",
                            "display": "routine"
                        }
                    ],
                    "text": "ไม่เร่งด่วน"
                },
                "period": {
                    "start": "2023-01-04T15:13:00.000Z",
                    "end": "0000-00-00T00:00:00.000Z"
                },
                "subject": {
                    "reference": "Patient/072746",
                    "display": "น.ส.ปราณี  โคตรจันทร์                              "
                },
                "screen_allergy": {
                    "system": "https://bps.moph.go.th/screen_allergy",
                    "code": "2",
                    "display": "ปฏิเสธแพ้ยา"
                },
                "screen_smoking": {
                    "system": "https://bps.moph.go.th/screen_smoking",
                    "code": "1",
                    "display": "ไม่สูบบุหรี่"
                },
                "screen_drinking": {
                    "system": "https://bps.moph.go.th/screen_smoking",
                    "code": "1",
                    "display": "ไม่ดื่มสุรา"
                },
                "participant": [
                    {
                        "individual": {
                            "type": {
                                "text": "แพทย์แผนไทย                                                 "
                            },
                            "reference": "พท.ว.23118",
                            "display": "พูลทรัพย์ จันทร์สมุด                              "
                        }
                    }
                ],
                "reason": [
                    {
                        "text": "   มึนชาปลายเท้า ทั้ง 2 ข้าง มา 1 สัปดาห์Present Illness "
                    }
                ],
                "financeTotalAmount": 0,
                "financeReimbursementAmount": 0,
                "financePaidAmount": 0,
                "Coverage": [
                    {
                        "identifier": [
                            {
                                "system": "https://www.nhso.go.th/certificate"
                            },
                            {
                                "system": "https://www.nhso.go.th/authcode",
                                "value": ""
                            }
                        ],
                        "status": "active",
                        "type": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
                                    "code": "PUBLICPOL",
                                    "display": "public healthcare"
                                }
                            ]
                        },
                        "relationship": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/subscriber-relationship",
                                    "code": "self",
                                    "display": "Self"
                                }
                            ]
                        },
                        "period": {
                            "start": "2023-09-28",
                            "end": "0000-00-00"
                        },
                        "payor": [
                            {
                                "reference": "สำนักงานหลักประกันสุขภาพแห่งชาติ"
                            }
                        ],
                        "class": [
                            {
                                "type": {
                                    "coding": [
                                        {
                                            "system": "http://terminology.hl7.org/CodeSystem/coverage-class",
                                            "code": "group"
                                        }
                                    ]
                                },
                                "value": "UCS",
                                "name": "สิทธิหลักประกันสุขภาพแห่งชาติ"
                            },
                            {
                                "type": {
                                    "coding": [
                                        {
                                            "system": "http://terminology.hl7.org/CodeSystem/coverage-class",
                                            "code": "subgroup"
                                        }
                                    ]
                                },
                                "value": "UC",
                                "name": "ประกันสุขภาพถ้วนหน้า"
                            }
                        ],
                        "reimbursementAmount": "0",
                        "contract": [
                            {
                                "reference": "MainHospital",
                                "identifier": "10953",
                                "display": "ม่วงสามสิบ;รพ."
                            },
                            {
                                "reference": "SubHospital",
                                "identifier": "03697",
                                "display": "รพ.สต.หนองเมือง(ม่วงฯ)                                      "
                            }
                        ]
                    }
                ],
                "vital_signs": [
                    {
                        "body_weight": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "kg"
                            }
                        },
                        "body_height": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "cm"
                            }
                        },
                        "body_temp": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "cel"
                            }
                        },
                        "bp_systolic": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "mmHg"
                            },
                            "interpretation": {}
                        },
                        "bp_diastolic": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "mmHg"
                            },
                            "interpretation": {}
                        }
                    },
                    {
                        "body_weight": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "kg"
                            }
                        },
                        "body_height": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "cm"
                            }
                        },
                        "body_temp": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "cel"
                            }
                        },
                        "bp_systolic": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "mmHg"
                            },
                            "interpretation": {}
                        },
                        "bp_diastolic": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "mmHg"
                            },
                            "interpretation": {}
                        }
                    },
                    {
                        "body_weight": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "kg"
                            }
                        },
                        "body_height": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "cm"
                            }
                        },
                        "body_temp": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "cel"
                            }
                        },
                        "bp_systolic": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "mmHg"
                            },
                            "interpretation": {}
                        },
                        "bp_diastolic": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "mmHg"
                            },
                            "interpretation": {}
                        }
                    },
                    {
                        "body_weight": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "kg"
                            }
                        },
                        "body_height": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "cm"
                            }
                        },
                        "body_temp": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "cel"
                            }
                        },
                        "bp_systolic": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "mmHg"
                            },
                            "interpretation": {}
                        },
                        "bp_diastolic": {
                            "status": "final",
                            "valueQuantity": {
                                "unit": "mmHg"
                            },
                            "interpretation": {}
                        }
                    }
                ],
                "Observation": [],
                "Condition": [
                    {
                        "clinicalStatus": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/conditionclinical",
                                    "code": "active",
                                    "display": "Active"
                                }
                            ]
                        },
                        "verificationStatus": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/condition-verstatus",
                                    "code": "confirmed",
                                    "display": "Confirmed"
                                }
                            ]
                        },
                        "category": [
                            {
                                "coding": [
                                    {
                                        "system": "http://snomed.info/sct",
                                        "code": "439401001",
                                        "display": "Diagnosis"
                                    }
                                ]
                            }
                        ],
                        "severity": {
                            "coding": [
                                {
                                    "system": "http://snomed.info/sct",
                                    "code": "24484000",
                                    "display": "Severe"
                                }
                            ]
                        },
                        "code": {
                            "coding": [
                                {
                                    "system": "http://hl7.org/fhir/sid/icd-10",
                                    "code": "U71..73",
                                    "display": "U71.73   ชา  อาการที่มีความรู้สึกน้อยกว่าปกติ  เกิดจากเส้นประสาทรับความรู้สึกถูกกด  ถูกตัดขาด  หรือถูกสารพิษ  เช่น  ชามือ  ชาเท้า  ชาแขน  ชาขา"
                                }
                            ],
                            "text": "U71.73   ชา  อาการที่มีความรู้สึกน้อยกว่าปกติ  เกิดจากเส้นประสาทรับความรู้สึกถูกกด  ถูกตัดขาด  หรือถูกสารพิษ  เช่น  ชามือ  ชาเท้า  ชาแขน  ชาขา"
                        },
                        "bodySite": [
                            {
                                "coding": [
                                    {
                                        "system": "http://snomed.info/sct",
                                        "code": "",
                                        "display": ""
                                    }
                                ],
                                "text": ""
                            }
                        ],
                        "recordedDate": "2023-01-04T15:14:04.000Z"
                    },
                    {
                        "clinicalStatus": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/conditionclinical",
                                    "code": "active",
                                    "display": "Active"
                                }
                            ]
                        },
                        "verificationStatus": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/condition-verstatus",
                                    "code": "confirmed",
                                    "display": "Confirmed"
                                }
                            ]
                        },
                        "category": [
                            {
                                "coding": [
                                    {
                                        "system": "http://snomed.info/sct",
                                        "code": "439401001",
                                        "display": "Diagnosis"
                                    }
                                ]
                            }
                        ],
                        "severity": {
                            "coding": [
                                {
                                    "system": "http://snomed.info/sct",
                                    "code": "24484000",
                                    "display": "Severe"
                                }
                            ]
                        },
                        "code": {
                            "coding": [
                                {
                                    "system": "http://hl7.org/fhir/sid/icd-10",
                                    "code": "R20.8",
                                    "display": "OTHER AND UNSPECIFIED DISTURBANCES OF SKIN SENSATION"
                                }
                            ],
                            "text": "OTHER AND UNSPECIFIED DISTURBANCES OF SKIN SENSATION"
                        },
                        "bodySite": [
                            {
                                "coding": [
                                    {
                                        "system": "http://snomed.info/sct",
                                        "code": "",
                                        "display": ""
                                    }
                                ],
                                "text": ""
                            }
                        ],
                        "recordedDate": "2023-01-04T15:14:04.000Z"
                    },
                    {
                        "clinicalStatus": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/conditionclinical",
                                    "code": "active",
                                    "display": "Active"
                                }
                            ]
                        },
                        "verificationStatus": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/condition-verstatus",
                                    "code": "confirmed",
                                    "display": "Confirmed"
                                }
                            ]
                        },
                        "category": [
                            {
                                "coding": [
                                    {
                                        "system": "http://snomed.info/sct",
                                        "code": "439401001",
                                        "display": "Diagnosis"
                                    }
                                ]
                            }
                        ],
                        "severity": {
                            "coding": [
                                {
                                    "system": "http://snomed.info/sct",
                                    "code": "24484000",
                                    "display": "Severe"
                                }
                            ]
                        },
                        "code": {
                            "coding": [
                                {
                                    "system": "http://hl7.org/fhir/sid/icd-10",
                                    "code": "U66..80",
                                    "display": "U66.80      ท้องอืด  ความรู้สึกว่ามีลมในกระเพาะหรือลำไส้  ทำให้แน่นอึดอัดในช่องท้อง"
                                }
                            ],
                            "text": "U66.80      ท้องอืด  ความรู้สึกว่ามีลมในกระเพาะหรือลำไส้  ทำให้แน่นอึดอัดในช่องท้อง"
                        },
                        "bodySite": [
                            {
                                "coding": [
                                    {
                                        "system": "http://snomed.info/sct",
                                        "code": "",
                                        "display": ""
                                    }
                                ],
                                "text": ""
                            }
                        ],
                        "recordedDate": "2023-01-04T15:14:04.000Z"
                    },
                    {
                        "clinicalStatus": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/conditionclinical",
                                    "code": "active",
                                    "display": "Active"
                                }
                            ]
                        },
                        "verificationStatus": {
                            "coding": [
                                {
                                    "system": "http://terminology.hl7.org/CodeSystem/condition-verstatus",
                                    "code": "confirmed",
                                    "display": "Confirmed"
                                }
                            ]
                        },
                        "category": [
                            {
                                "coding": [
                                    {
                                        "system": "http://snomed.info/sct",
                                        "code": "439401001",
                                        "display": "Diagnosis"
                                    }
                                ]
                            }
                        ],
                        "severity": {
                            "coding": [
                                {
                                    "system": "http://snomed.info/sct",
                                    "code": "24484000",
                                    "display": "Severe"
                                }
                            ]
                        },
                        "code": {
                            "coding": [
                                {
                                    "system": "http://hl7.org/fhir/sid/icd-10",
                                    "code": "K30",
                                    "display": "FUNCTIONAL DYSPEPSIA                                                                                                                                                                                                                            "
                                }
                            ],
                            "text": "FUNCTIONAL DYSPEPSIA                                                                                                                                                                                                                            "
                        },
                        "bodySite": [
                            {
                                "coding": [
                                    {
                                        "system": "http://snomed.info/sct",
                                        "code": "",
                                        "display": ""
                                    }
                                ],
                                "text": ""
                            }
                        ],
                        "recordedDate": "2023-01-04T15:14:04.000Z"
                    }
                ],
                "Medication": [
                    {
                        "code": {
                            "coding": [
                                {
                                    "system": "https://www.this.or.th/tmt/gp",
                                    "code": "00000",
                                    "display": "ขมิ้นชัน Cap (600 mg/1Cap)"
                                }
                            ],
                            "text": "ขมิ้นชัน"
                        },
                        "form": {
                            "coding": [
                                {
                                    "system": "http://snomed.info/sct",
                                    "code": "732937005",
                                    "display": "02"
                                }
                            ]
                        },
                        "finance": {
                            "qty": 20,
                            "unitPrice": null
                        },
                        "statement": {
                            "status": "active",
                            "category": {
                                "coding": [
                                    {
                                        "system": "http://terminology.hl7.org/CodeSystem/medication-statement-category",
                                        "code": "outpatient",
                                        "display": "ผู้ป่วยนอก"
                                    }
                                ]
                            },
                            "effectiveDateTime": "2023-01-04T15:13:00.000Z",
                            "note": [
                                {
                                    "time": "2023-01-04T15:13:00.000Z",
                                    "text": "ทดสอบ Note"
                                }
                            ],
                            "dosage": [
                                {
                                    "sequence": 1,
                                    "text": "Oral",
                                    "patientInstruction": "",
                                    "timing": {
                                        "repeat": {
                                            "frequency": 3,
                                            "period": 1,
                                            "periodUnit": "d"
                                        }
                                    },
                                    "route": {
                                        "coding": [
                                            {
                                                "system": "http://standardterms.edqm.eu",
                                                "code": "20053000",
                                                "display": "กิน"
                                            }
                                        ]
                                    },
                                    "doseAndRate": [
                                        {
                                            "type": {
                                                "coding": [
                                                    {
                                                        "system": "http://terminology.hl7.org/CodeSystem/dose-rate-type",
                                                        "code": "ordered",
                                                        "display": "Ordered"
                                                    }
                                                ]
                                            },
                                            "doseQuantity": {
                                                "value": 1,
                                                "unit": "tablet",
                                                "system": "http://http://snomed.info/sct",
                                                "code": "732936001"
                                            }
                                        }
                                    ]
                                }
                            ]
                        }
                    },
                    {
                        "code": {
                            "coding": [
                                {
                                    "system": "https://www.this.or.th/tmt/gp",
                                    "code": "00000",
                                    "display": "ยาหอมนวโกฐ (ซอง) Powder (15 gm/1ซอง)"
                                }
                            ],
                            "text": "ยาหอมนวโกฐ (ซอง)"
                        },
                        "form": {
                            "coding": [
                                {
                                    "system": "http://snomed.info/sct",
                                    "code": "732937005",
                                    "display": "08"
                                }
                            ]
                        },
                        "finance": {
                            "qty": 1,
                            "unitPrice": null
                        },
                        "statement": {
                            "status": "active",
                            "category": {
                                "coding": [
                                    {
                                        "system": "http://terminology.hl7.org/CodeSystem/medication-statement-category",
                                        "code": "outpatient",
                                        "display": "ผู้ป่วยนอก"
                                    }
                                ]
                            },
                            "effectiveDateTime": "2023-01-04T15:13:00.000Z",
                            "note": [
                                {
                                    "time": "2023-01-04T15:13:00.000Z",
                                    "text": "ทดสอบ Note"
                                }
                            ],
                            "dosage": [
                                {
                                    "sequence": 1,
                                    "text": "Oral",
                                    "patientInstruction": "ระวังการรับประทานร่วมกับยาในกลุ่มสารกันเลือดเป็นลิ่ม (anticoagulant) และยาต้านการจับตัวของเกล็ดเลือด (antiplatelets)",
                                    "timing": {
                                        "repeat": {
                                            "frequency": 3,
                                            "period": 1,
                                            "periodUnit": "d"
                                        }
                                    },
                                    "route": {
                                        "coding": [
                                            {
                                                "system": "http://standardterms.edqm.eu",
                                                "code": "20053000",
                                                "display": "กิน"
                                            }
                                        ]
                                    },
                                    "doseAndRate": [
                                        {
                                            "type": {
                                                "coding": [
                                                    {
                                                        "system": "http://terminology.hl7.org/CodeSystem/dose-rate-type",
                                                        "code": "ordered",
                                                        "display": "Ordered"
                                                    }
                                                ]
                                            },
                                            "doseQuantity": {
                                                "value": 1,
                                                "unit": "tablet",
                                                "system": "http://http://snomed.info/sct",
                                                "code": "732936001"
                                            }
                                        }
                                    ]
                                }
                            ]
                        }
                    }
                ],
                "Appointment": [],
                "Immunization": [],
                "Claim": []
            }
        ]
    }
    

?>