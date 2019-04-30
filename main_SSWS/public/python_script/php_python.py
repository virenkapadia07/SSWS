import pandas as pd
import sys

#user_day=input("Enter Day: ")
#user_day=user_day.upper()
#user_faculity=input("Enter Faculity: ")
#user_faculity=user_faculity.upper()

user_day=sys.argv[1].upper()
user_faculity=sys.argv[2].upper()

try:
    data2=pd.read_csv("python_script/table_1.csv",keep_default_na=False)
    data2.columns=data2.columns.str.replace('\n','_')
    data2.columns=data2.columns.str.replace('-','_')
    data2.columns=data2.columns.str.replace(' ','_')
    data2.columns=data2.columns.str.replace('(','')
    data2.columns=data2.columns.str.replace(')','')
    classes=list(data2.columns)
    classes=classes[2:10]

    all_classes={}
    for clss in classes:
        list_name=[]
        for names in data2[clss]:
            name=names.replace('\n',' ')
            name=str(name)
            if name.find('(')!=-1:
                tmp=name
                name=name[name.find('(')+1:name.find(')')]
                tmp=tmp[tmp.find(')')+1:]
                if tmp.find('(')!=-1:
                    tmp=tmp[tmp.find('(')+1:tmp.find(')')]
                    if len(name)==3:
                        if tmp not in list_name:
                            list_name.append(tmp)
                if len(name)==3:
                    if name not in list_name:
                        list_name.append(name)
        all_classes[clss]=list_name

    keys_of_classes=list(all_classes.keys())

    final_result={}

    #Finding avaliable lectures
    data=pd.read_csv("python_script/table_2.csv",keep_default_na=False)
    data.columns=data.columns.str.replace('\n','_')
    data.columns=data.columns.str.replace('-','_')
    data.columns=data.columns.str.replace(' ','_')
    data.columns=data.columns.str.replace('(','')
    data.columns=data.columns.str.replace(')','')
    select_day=data[data.DAY==user_day]
    select_day=select_day.copy()
    select_day['period']=[1,2,3,4,5,6]
    avaliable_lectures=select_day[user_faculity][select_day[user_faculity]!=""]
    avaliable_lectures=avaliable_lectures.replace("\n"," ",regex=True)
    index_values=avaliable_lectures.index
    for index_value in index_values:
        combine_lectures=0
        details=avaliable_lectures.loc[index_value]
        details=str(details)
        if ("LAB" in details) or ("CENTRAL" in details):
            combine_lectures=1
        details=details.split()
        subject_name=details[0]
        if len(details)==5:
            class_room=details[3]+" "+details[4]
            semester=details[2][0]
            department=details[2][2:]
        elif len(details)==3:
            class_room=details[2]
            semester=details[1][0]
            department=details[1][2:]
        elif "PROJECT" in str(details):
            class_room="Not Defined"
            semester=details[3][0]
            department=details[3][2:]
        else:
            class_room=details[2]+" "+details[3]
            semester=details[1][0]
            department=details[1][2:]
        period_no=select_day.loc[index_value,'period']
        period_no=str(period_no)
        period_no=period_no.split()
        period_no=int(period_no[0])

        #finding year
        year=""
        if semester=='1' or semester=='2':
            year="I"
        elif semester=='3' or semester=='4':
            year="II"
        elif semester=='5' or semester=='6':
            year="III"
        elif semester=='7' or semester=='8':
            year="IV"

        #Finding class keys(means finding class name)    
        for i in keys_of_classes:
            if department in i:
                if year in i:
                    if year=='I':
                        if "II" not in i:
                            if "III" not in i:
                                key=i
                    elif year=='II':
                        if "III" not in i:
                            key=i
                    elif year=="III":
                        key=i
                    elif year=="IV":
                        key=i
        taking_fac=all_classes[key]

        #Checking for free faculity
        free_fac=[]
        for i in taking_fac:
            try:
                a=str(data[i].loc[[index_value]]=="")
                lab=0
                if period_no%2==0:
                    checking_lab=str(data[i].loc[[index_value-1]])
                    if "LAB" in checking_lab or "CENTRAL" in checking_lab:
                        lab=1
                if lab==0:
                    if "True" in a:
                        free_fac.append(i)
            except KeyError:
                continue
        final_result[str(period_no)+'_'+str(semester)+'-'+department]=free_fac

        #Arranging lectures for lab(second slot)
        free_fac=[]
        if combine_lectures==1:
            for i in taking_fac:
                try:
                    a=str(data[i].loc[[index_value+1]]=="")
                    lab=0
                    if (period_no+1)%2==0:
                        checking_lab=str(data[i].loc[[index_value]])
                        if "LAB" in checking_lab or "CENTRAL" in checking_lab:
                            if semester+"-"+department in checking_lab:
                                lab=1
                                if i!=user_faculity:
                                    free_fac.append(i)
                except KeyError:
                    continue
            x=data.loc[[index_value]]

            #Seraching for faculty taking lectures
            for f_name in x:
                for f_details in x[f_name]:
                    if semester+"-"+department in str(f_details) and ("LAB" in str(f_details) or "CENTRAL" in str(f_details)):
                        if f_name not in free_fac and f_name!=user_faculity:
                            free_fac.append(f_name)
                final_result[str(period_no+1)+'_'+str(semester)+'-'+department]=free_fac
                final_result[str(period_no)+'_'+str(semester)+'-'+department]=free_fac
    print(final_result)

except Exception:
    print("Entered Detail is wrong")