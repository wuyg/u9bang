using System;
using System.Data.SqlClient;
using log4net;

namespace UFIDA.U9.Helper
{
    public static class ParallelUtility
    {
        private static readonly ILog log = LogManager.GetLogger(typeof(ParallelUtility));

        //获取SQLServer 的执行器数量（CPU数量）
        public static int GetSQLSchedulerCount( string connStr )
        {
            try
            {
                string sqlString = "select SUM(online_scheduler_count) from sys.dm_os_nodes where node_state_desc='ONLINE'";
                using (SqlConnection sqlConn = new SqlConnection(connStr))
                {
                    sqlConn.Open();
                    SqlCommand command = new SqlCommand(sqlString, sqlConn);
                    int x = (int)command.ExecuteScalar();
                    sqlConn.Close();
                    return x;
                }
            }
            catch (Exception e)
            {
                log.WarnFormat(e.Message, e);
                log.Warn("获取SQLServer并行度sys.dm_os_nodes，desc=ONLINE时出现错误，升级程序假定数据库的并行度为4");
                return 4;
            }
        }

        /// <summary>
        /// 从数据库表UBF_ARCustomCPUCount获取自定义并行度
        /// </summary>
        /// <param name="connStr"></param>
        /// <returns></returns>
        public static int GetCustomSchedulerCount(string connStr)
        {
            try
            {
                string sqlString = "if OBJECT_ID('UBF_ARCustomCPUCount') is not null Begin Select Top 1 CPUCount from UBF_ARCustomCPUCount End Else Begin Select -1 as CPUCount End";
                using (SqlConnection sqlConn = new SqlConnection(connStr))
                {
                    sqlConn.Open();
                    SqlCommand command = new SqlCommand(sqlString, sqlConn);
                    int x = (int)command.ExecuteScalar();
                    sqlConn.Close();
                    return x;
                }
            }
            catch (Exception e)
            {
                log.WarnFormat(e.Message, e);
                log.Warn("获取自定义并行度时出现错误，默认返回-1");
                return -1;
            }
        }
       
    }
}
